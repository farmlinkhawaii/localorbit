class AttemptCreditCardPurchase
  include Interactor

  def perform
    if order_params["payment_method"] == 'credit card'
      order.update(payment_method: 'credit card')
    end
  end
end
