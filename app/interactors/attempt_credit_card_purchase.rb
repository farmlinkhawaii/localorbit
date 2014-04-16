class AttemptCreditCardPurchase
  include Interactor

  def perform
    if order_params["payment_method"] == 'credit card'
      begin
        card = cart.organization.bank_accounts.find(order_params["credit_card"])
        balanced_card = Balanced::Card.find(card.balanced_uri)

        if balanced_card.hold(amount: order.total_cost, description: "LocalOrbit market purchase")
          order.update(payment_method: 'credit card')
        else
          context.fail!
        end
      rescue
        context.fail!
      end
    end
  end
end
