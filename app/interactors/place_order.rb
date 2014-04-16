class PlaceOrder
  include Interactor::Organizer

  organize CreateOrder, StoreOrderFees, AttemptPurchaseOrderPurchase, AttemptCreditCardPurchase, SendOrderEmails, DeleteCart
end
