class CreateOrder
  include Interactor

  def perform
    context[:order] = create_order_from_cart(order_params, cart, buyer)
    context.fail! if context[:order].errors.any?
  end

  def rollback
    if context[:order]
      context[:order].destroy
    end
  end

  protected

  def create_order_from_cart(params, cart, buyer)
    billing = cart.organization.locations.default_billing

    order = Order.new(
      payment_provider: payment_provider,
      placed_by: buyer,
      order_number: OrderNumber.new(cart.market).id,
      organization: cart.organization,
      market: cart.market,
      delivery: cart.delivery,
      discount: discount,
      billing_organization_name: cart.organization.name,
      billing_address: billing.address,
      billing_city: billing.city,
      billing_state: billing.state,
      billing_zip: billing.zip,
      billing_phone: billing.phone,
      payment_status: "unpaid",
      payment_method: params[:payment_method],
      payment_note: params[:payment_note],
      delivery_fees: cart.delivery_fees,
      total_cost: cart.total,
      placed_at: DateTime.current
    )

    order.apply_delivery_address(cart.delivery_location)

    ActiveRecord::Base.transaction do
      order.add_cart_items(cart.items, cart.delivery.deliver_on)

      raise ActiveRecord::Rollback unless order.save
    end

    order
  end

  def discount
    cart.discount if cart.has_valid_discount?
  end
end
