class UpdateBalancedPurchase
  include Interactor

  def perform
    if ['credit card', 'ach'].include?(order.payment_method)
      current_amount = rollup_payment_amounts

      if current_amount > order.total_cost
        create_refunds(current_amount)
      elsif current_amount < order.total_cost
        create_new_charge(current_amount)
      end
    end
  end

  def rollup_payment_amounts
    order.payments.refundable.inject(0) {|sum, payment| sum = sum + payment.amount }
  end

  def create_refunds(amount)
    refund_amount = amount - order.total_cost

    refund(refund_amount)
    fail! if context[:status] == 'failed'

    record_payment("order refund", -refund_amount, nil)
  end

  def refund(amount)
    begin
      remaining_amount = amount
      order.payments.refundable.each do |payment|
        break unless remaining_amount

        debit, context[:type] = fetch_balanced_debit(payment.balanced_uri)

        refund_amount = [remaining_amount, payment.unrefunded_amount].min
        debit.refund(amount: refund_amount.to_i * 100)

        payment.increment!(:refunded_amount, refund_amount)
        remaining_amount -= refund_amount
      end
      context[:status] = 'paid'

    rescue Exception => e
      process_exception(e)
    end
  end

  def create_new_charge(amount)
    charge_amount = order.total_cost - amount

    debit = charge(charge_amount)
    fail! if context[:status] == 'failed'

    record_payment("order", amount, debit)
  end

  def charge(amount)
    begin
      debit, context[:type] = fetch_balanced_debit(first_order_payment.balanced_uri)
      customer = Balanced::Customer.find(debit.account.uri)

      new_debit = customer.debit(
        amount: amount.to_i * 100,
        source_uri: debit.source.uri,
        description: "#{order.market.name} purchase"
      )
      context[:status] = 'paid'

      new_debit
    rescue Exception => e
      process_exception(e)
    end
  end

  def first_order_payment
    order.payments.order(:created_at).first
  end

  def fetch_balanced_debit(uri)
    debit = Balanced::Debit.find(uri)
    type = debit.source._type == 'card' ? "credit card" : "ach"

    [debit, type]
  end

  def process_exception(exception)
    Honeybadger.notify_or_ignore(exception) unless Rails.env.test? || Rails.env.development?
    context[:status] = 'failed'

    raise exception if Rails.env.development?
  end

  def record_payment(type, amount, debit)
    adjustment_payment = Payment.create(
      payer: order.organization,
      payment_type: type,
      payment_method: context[:type],
      amount: amount,
      status: context[:status],
      balanced_uri: debit.try(:uri)
    )

    order.payments << adjustment_payment
  end
end
