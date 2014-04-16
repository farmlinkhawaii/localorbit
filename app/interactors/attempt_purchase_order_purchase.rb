class AttemptPurchaseOrderPurchase
  include Interactor

  def perform
    if order_params["payment_method"] == 'purchase order'
      order.update(payment_method: 'purchase order')
    end
  end
end
