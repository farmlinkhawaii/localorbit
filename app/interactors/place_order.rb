class PlaceOrder
  include Interactor::Organizer

  organize CreateOrder, AttemptPurchaseOrderPurchase, AttemptCreditCardPurchase, StoreOrderFees, SendOrderEmails, DeleteCart
end
