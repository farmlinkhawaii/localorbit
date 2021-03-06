module PaymentProvider
  class Stripe
    DefaultCurrencies = {'CA' => 'CAD', 'US' => 'USD'}

    CreditCardFeeStructure = SchemaValidation.validate!(FeeEstimator::Schema::BasePlusRate,
      style: :base_plus_rate,
      base:  30,
      rate:  BigDecimal.new("0.029") #{}"0.029".to_d, # 2.9% of total
    )

    TransferSchedule = {
      delay_days:    5,
      interval:      'weekly',
      weekly_anchor: 'wednesday'
    }

    module CardSchema
      Base = RSchema.schema {{
        name: String,
        bank_name: String,
        account_type: String,
        last_four: String,
        expiration_month: String,
        expiration_year: String,
        _?(:notes) => String,
      }}

      SubmittedParams = RSchema.schema do
        Base.merge(
          _?(:id) => String,
          _?(:save_for_future) => String,
          :stripe_tok => String
        )
      end

      NewParams = RSchema.schema do
        Base.merge(
          _?(:stripe_id) => String,
          _?(:deleted_at) => Time
        )
      end
    end

    class << self
      def id; :stripe; end

      def supported_payment_methods
        [ "credit card" ]
      end

      def addable_payment_methods
        [ "credit card" ]
      end

      def place_order(buyer_organization:, user:, order_params:, cart:, request:)
        PlaceStripeOrder.perform(payment_provider: self.id.to_s,
                                 entity: buyer_organization,
                                 user: user,
                                 order_params: order_params,
                                 cart: cart, request: request,
                                 holdover: false, repack: false
                                )
      end

      def translate_status(charge:, amount:nil, payment_method:nil)
        if charge.nil?
          if amount == 0 and payment_method == "credit card"
            # Sigh.  The overarching payment processing scheme is to treat CC payments of $0.00 as instantly "paid"
            # without actually executing a transaction with the provider...
            return "paid"
          else
            # ...but generally, missing charge is a sign of failure:
            return "failed"
          end
        end

        case charge.status
        when 'pending'
          'pending'
        when 'succeeded'
          'paid'
        else
          'failed'
        end
      end

      def default_currency_for_country(country)
        if (DefaultCurrencies[country])
          DefaultCurrencies[country]
        else
          raise ArgumentError, "#{country} is not a supported country."
        end
      end

      def charge_for_order(amount:, bank_account:, market:, order:, buyer_organization:)
        amount_in_cents = ::Financials::MoneyHelpers.amount_to_cents(amount)
        customer = buyer_organization.stripe_customer_id || raise("Can't create a charge; Organization #{buyer_organization.name} (#{buyer_organization.id}) has no stripe_customer_id")
        source = bank_account.stripe_id || raise("Can't create a charge; BankAccount #{bank_account.bank_name} #{bank_account.last_four} (#{bank_account.id}) has no stripe_id")
        destination = market.stripe_account_id
        descriptor = market.on_statement_as

        fee_in_cents = PaymentProvider::FeeEstimator.estimate_payment_fee CreditCardFeeStructure, amount_in_cents

        # TODO: once we support ACH via Stripe, this branch will be needed for an alternate estimate of ACH fees:
        # fee_in_cents = if bank_account.credit_card?
        #                  estimate_credit_card_processing_fee_in_cents(amount_in_cents)
        #                else
        #                  estimate_ach_processing_fee_in_cents(amount_in_cents)
        #                end
        metadata = {
          market: market.name,
          market_id: market.id,
          order_number: order.order_number,
          order_id: order.id,
          buyer_organization: buyer_organization.name,
          buyer_organization_id: buyer_organization.id,
          bank_account_id: bank_account.id,
          market_stripe_account: market.stripe_account_id,
        }

        charge_params = {
          amount: amount_in_cents,
          currency: self.default_currency_for_country(market.country).downcase,
          source: source,
          customer: customer,
          destination: destination,
          statement_descriptor: descriptor,
          application_fee: fee_in_cents,
          description: "Charge for #{order.order_number}"
        }

        if destination.nil?
          data = { charge_params: charge_params, metadata: metadata }
          message = "Can't create a Stripe charge! Market '#{market.name}' (#{market.id}) has no Stripe Account.  #{data.to_json}"
          raise message
        end

        charge = ::Stripe::Charge.create(charge_params)

        # Pin some order metadata on the Stripe::Payment object that appears in the managed account:
        transfer = ::Stripe::Transfer.retrieve(charge.transfer)
        payment = ::Stripe::Charge.retrieve(transfer.destination_payment, {stripe_account: transfer.destination})
        payment["metadata"]["lo.order_id"] = order.id.to_s
        payment["metadata"]["lo.order_number"] = order.order_number
        payment.save

        return charge
      rescue ::Stripe::StripeError => e
        data = {
          error_json_body: e.json_body,
          charge_params: charge_params,
          metadata: {
            market: market.name,
            market_id: market.id,
            order_number: order.order_number,
            order_id: order.id,
            buyer_organization: buyer_organization.name,
            buyer_organization_id: buyer_organization.id,
            bank_account_id: bank_account.id,
            market_stripe_account: market.stripe_account_id,
          }
        }
        new_message = "(Status #{e.http_status}) #{e.message} #{data.to_json}"
        new_err = ::Stripe::StripeError.new(new_message, e.http_status, e.http_body, data)
        new_err.set_backtrace(e.backtrace)
        raise new_err
      end

      def fully_refund(charge:nil, payment:, order:)
        charge ||= ::Stripe::Charge.retrieve(payment.stripe_id)
        charge.refunds.create(refund_application_fee: true,
                              reverse_transfer: true,
                              metadata: { 'lo.order_id' => order.id,
                                          'lo.order_number' => order.order_number })
      end

      def store_payment_fees(order:)
        total_fee = order.payments.where(payment_type: 'order').sum(:stripe_payment_fee)
        total_fee_cents = ::Financials::MoneyHelpers.amount_to_cents(total_fee)
        fees = distribute_fee_amongst_order_items(total_fee_cents, order)

        fee_payer = order.market.credit_card_payment_fee_payer
        order.items.each do |item|
          fee_cents = fees[item.id]
          fee = if fee_cents.nil?
                  0.to_d
                else
                  ::Financials::MoneyHelpers.cents_to_amount(fee_cents)
                end
          if fee_payer == 'market' && item.payment_market_fee == 0 && item.payment_seller_fee == 0
            item.update :"payment_market_fee" => fee
          elsif fee_payer == 'seller' && item.payment_market_fee == 0 && item.payment_seller_fee == 0
            item.update :"payment_seller_fee" => fee
          elsif item.payment_market_fee > 0
            item.update :"payment_market_fee" => fee
          elsif item.payment_seller_fee > 0
            item.update :"payment_seller_fee" => fee
          end

        end
        nil
      end

      def create_order_payment(charge:, market_id:, bank_account:, payer:,
                                  payment_method:, amount:, order:, status:)
        stripe_id = if charge then charge.id else nil end

        Payment.create(
          payment_provider: self.id.to_s,
          market_id: market_id,
          bank_account: bank_account,
          payer: payer,
          payment_method: payment_method,
          amount: amount,
          payment_type: 'order',
          orders: [order],
          status: status,
          stripe_id: stripe_id,
          stripe_payment_fee: get_stripe_application_fee_for_charge(charge)
        )
      end

      def create_refund_payment(charge:, market_id:, bank_account:, payer:,
                                    payment_method:, amount:, order:, status:, refund:, parent_payment:)
        stripe_id = charge ? charge.id : nil
        stripe_refund_id = refund ? refund.id : nil

        payment = Payment.create(
          payment_provider: self.id.to_s,
          market_id: market_id,
          bank_account: bank_account,
          payer: payer,
          payment_method: payment_method,
          amount: amount,
          payment_type: 'order refund',
          orders: [order],
          parent_id: parent_payment.id,
          status: status,
          stripe_id: stripe_id,
          stripe_refund_id: stripe_refund_id
        )
        parent_payment.update stripe_payment_fee: get_stripe_application_fee_for_charge(charge)
        return payment
      end

      def find_charge(payment:)
        ::Stripe::Charge.retrieve(payment.stripe_id)
      end

      def refund_charge(charge:, amount:, order:)
        amount_in_cents = ::Financials::MoneyHelpers.amount_to_cents(amount)
        charge.refunds.create(refund_application_fee: true,
                              reverse_transfer: true,
                              amount: amount_in_cents,
                              metadata: {
                                'lo.order_id' => order.id,
                                'lo.order_number' => order.order_number
                              })
        # TODO: If refund fails - might be due to trying to apply refund against a standalone account, after conversion from managed. Need to trap and use legacy account instead

      end

      def add_payment_method(type:, entity:, bank_account_params:, representative_params:)
        if type == "card"

          AddStripeCreditCardToEntity.perform(
            entity: entity,
            bank_account_params: bank_account_params,
            representative_params: representative_params)
        else
          raise "PaymentProvider::Stripe doesn't support adding payment methods of type #{type.inspect}; only 'card' supported currently."
        end
      end

      def add_deposit_account(entity:, type:, bank_account_params:)
        if type == 'checking'
          AddStripeDepositAccountToMarket.perform(
            entity: entity,
            bank_account_params: bank_account_params)
        else
          raise "PaymentProvider::Stripe only supports adding Deposit Accounts of type 'checking'; dunno what to do with this type: #{type.inspect}"
        end
      end

      def approximate_credit_card_rate
        CreditCardFeeStructure[:rate] # should be decimal value 0.029, see above
      end

      # Coordinates the creation of a customer subscription
      def upsert_subscription(entity, subscription_params)
        raise "'#{entity.name}' has no Stripe Account" if entity.stripe_customer_id.blank?

        customer = get_stripe_customer(entity.try(:stripe_customer_id))
        raise "'#{entity.name}' has no Stripe Account" if customer.nil?
        raise "Stripe account for '#{entity.name}' is deleted" if customer.try(:deleted) == true
        raise "'#{entity.name}' has no default payment method in Stripe" if customer.try(:default_source).blank? && subscription_params[:source].blank?

        # Initialize 'subscription not found' state
        subscription = nil

        # Gather data
        submission_data = {
          plan: subscription_params[:plan],
          metadata: {
            "lo_entity_id" => entity.id,
            "lo_entity_type" => entity.class.name.underscore,
            "lo_entity_name" => entity.name
          }
        }
        # Stripe uses the default card if one exists, making this value optional
        submission_data[:source] = subscription_params[:source] if subscription_params[:source].present?

        # Stripe complains if you pass an empty coupon.  Only add it if it exists
        submission_data[:coupon] = subscription_params[:coupon] if subscription_params[:coupon].present?

        customer.subscriptions.data.each do |sub|
          # If an existing subscription matches the current data...
          if sub.plan.id == subscription_params[:plan]
            # ...then update the subscription:
            subscription        = customer.subscriptions.retrieve(sub.id)
            subscription.plan   = submission_data[:plan]
            subscription.source = submission_data[:source] if submission_data[:source].present?
            subscription.coupon = submission_data[:coupon] if submission_data[:coupon].present?
            subscription.save

          else
            # Otherwise delete it:
            customer.subscriptions.retrieve(sub.id).delete
          end
        end

        # If no matching subscription was found...
        if subscription.nil?
          # ...just create one
          subscription = customer.subscriptions.create(submission_data)
        end

        subscription
      end

      #
      #
      # NON-PaymentProvider interface:
      #
      #

      # create_customer
      # params customer_data Hash containing description: (entity.name) and metadata: (entity id and class name)
      # return Stripe customer object
      def create_customer(customer_data)
        ::Stripe::Customer.create(customer_data)
      end

      # get_stripe_customer
      # params stripe_customer_id String The Stripe customer id for the entity in question
      # return Stripe customer object
      def get_stripe_customer(stripe_customer_id)
        ::Stripe::Customer.retrieve(stripe_customer_id)
      end

      def get_stripe_subscription(subscription_id)
        ::Stripe::Subscription.retrieve(subscription_id)
      end

      def delete_stripe_subscription(stripe_customer_id, subscription_id)
        customer = get_stripe_customer(stripe_customer_id)
        customer.subscriptions.retrieve(subscription_id).delete
      end

      def create_stripe_card_for_stripe_customer(stripe_customer:nil,stripe_customer_id:nil, stripe_tok:)
        customer = stripe_customer || ::Stripe::Customer.retrieve(stripe_customer_id)
        credit_card = customer.sources.create(source: stripe_tok)
        set_default_source(customer, credit_card)
        credit_card
      end

      # set_default_source
      # Update the Stripe customer to reflect a new default source.  By
      # default this happens whenever a customer adds a new credit card,
      # though we may want to expose this as an option
      def set_default_source(stripe_customer, stripe_card)
        # Only credit cards should be set as the default source
        return unless stripe_card.object == "card"

        customer = ::Stripe::Customer.retrieve(stripe_customer.id)

        customer.default_source = stripe_card.id
        customer.save

        customer
      end


      def order_ids_for_market_payout_transfer(transfer_id:, stripe_account_id:)

        order_ids = enumerate_transfer_transactions(transfer_id: transfer_id, stripe_account_id: stripe_account_id).map do |transaction|
          if metadata = transaction.try(:source).try(:metadata)
            order_id = metadata['lo.order_id']
            order_id.to_i unless order_id.nil?
          end
        end
        order_ids.compact.uniq
      end

      def create_market_payment(transfer_id:, market:, order_ids:, status:, amount:)
        Payment.create!(
          payment_provider: self.id.to_s,
          payment_type:   amount < 0 ? "lo fee" : "market payment",
          amount:         amount,
          status:         status,
          stripe_transfer_id: transfer_id,
          market:         market,
          payee:          market,
          bank_account:   market.deposit_account,
          orders:         Order.where(id: order_ids),
          payment_method: "ach"
        )
      end

      def select_usable_bank_accounts(bank_accounts)
        bank_accounts.reject do |ba| ba.stripe_id.nil? end
      end

      def remove_unused_bank_accounts(stripe_account)
        account = ::Stripe::Account.retrieve(stripe_account.id)
        bank_accounts = account.bank_accounts
        bank_accounts.each do |a|
          if !a.default_for_currency
            del_result = a.delete
          end
        end
      end

      def glean_card(stripe_object)
        case stripe_object.object
        when "charge"
          card     = stripe_object.source
        when "customer"
         card     = self.get_stripe_card(customer.default_source)
        when "invoice"
          charge   = self.get_charge(stripe_object.charge)
          card     = self.glean_card(charge)

        else
          # This is a cop-out and means that the returned object must be examined before
          # using, but it'd better than raising an error at this vestigial stage...
          stripe_object
        end
      end

      #
      # General Stripe getters
      #
      #
      def get_charge(stripe_charge_id)
        ::Stripe::Charge.retrieve(stripe_charge_id)
      end

      def get_stripe_card(card_id)
        ::Stripe::Sources.retrieve(card_id)
      end

      def get_stripe_plans(plan = nil)
        if plan.nil?
          ::Stripe::Plan.all.data
        else
          ::Stripe::Plan.retrieve(plan.upcase)
        end
      end

      def get_stripe_coupon(coupon)
        ::Stripe::Coupon.retrieve(coupon)
      end

      def get_stripe_invoices(customer_filter = nil)
        ::Stripe::Invoice.all(customer_filter)
      end

      def get_stripe_account_status(acct)
        ::Stripe::Account.retrieve(acct)
      end

      def get_stripe_balance(acct)
        ::Stripe::Balance.retrieve(stripe_account: acct)
      end

      def get_stripe_balance_transactions(acct)
        response = ::Stripe::BalanceTransaction.all({limit: 10}, {stripe_account: acct})
        response.data
      end

      def get_stripe_charge_transactions(acct)
        response = ::Stripe::Charge.all({limit: 10}, {stripe_account: acct})
        response.data
      end

      def get_stripe_transfers(acct)
        response = ::Stripe::Transfer.all({limit: 10}, {stripe_account: acct})
        response.data
      end

      private

      def enumerate_transfer_transactions(transfer_id:, stripe_account_id:)
        response = ::Stripe::BalanceTransaction.all(
          {limit: 100, type: 'payment', expand: ['data.source'],
            transfer: transfer_id}, {stripe_account: stripe_account_id})

        response.data
      end


      def distribute_fee_amongst_order_items(total_fee_cents, order)
        order_total_cents = ::Financials::MoneyHelpers.amount_to_cents(order.gross_total)

        LargestRemainder.distribute_shares(
          to_distribute: total_fee_cents,
          total:         order_total_cents,
          items:         order.usable_items.inject({}) do |memo,item|
                           memo[item.id] = ::Financials::MoneyHelpers.amount_to_cents(item.gross_total)
                           memo
                         end
        )
      end

      def get_stripe_application_fee_for_charge(charge)
        return "0".to_d unless charge

        app_fee = ::Stripe::ApplicationFee.retrieve(charge.application_fee)
        if app_fee
          ::Financials::MoneyHelpers.cents_to_amount(app_fee.amount - app_fee.amount_refunded)
        else
          "0".to_d
        end
      end


    end

  end
end
