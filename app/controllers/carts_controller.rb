class CartsController < ApplicationController
  before_action :require_market_open
  before_action :require_current_organization
  before_action :require_organization_location
  before_action :require_current_delivery
  before_action :require_cart
  before_action :hide_admin_navigation
  before_action :set_payment_provider

  def show
    respond_to do |format|
      format.html do
        if current_cart.items.empty?
          redirect_to [:products], alert: "Your cart is empty. Please add items to your cart before checking out."
        else
          @grouped_items = current_cart.items.for_checkout

          if !flash.now[:discount_message] && current_cart.discount.present?
            @apply_discount = ApplyDiscountToCart.perform(cart: current_cart, code: current_cart.discount.code)
            flash.now[:discount_message] = @apply_discount.context[:message]
          end
        end
      end
      format.json do
        total = if current_cart then current_cart.items.count else 0 end
        render json: {:total=>total}
      end
    end
  end

  def update
    product = Product.includes(:prices).find(params[:product_id])
    delivery_date = current_delivery.deliver_on

    @item = current_cart.items.find_or_initialize_by(product_id: product.id)

    if params[:quantity].to_i > 0
      @item.quantity = params[:quantity]
      @item.product = product

      if @item.quantity && @item.quantity > 0 && @item.quantity > product.available_inventory(delivery_date)
        @error = "Quantity of #{product.name} available for purchase: #{product.available_inventory(delivery_date)}"
        @item.quantity = product.available_inventory(delivery_date)
      end

      @error = @item.errors.full_messages.join(". ") unless @item.save
    elsif @item.persisted?
      @item.update(quantity: 0)
      @item.destroy
    end

    flash[:error] = @error unless !@error
    @apply_discount = current_cart.discount ? ApplyDiscountToCart.perform(cart: current_cart, code: current_cart.discount.code) : nil
  end

  # add Delivery Note deletion to cart's destroy
  def destroy
    DeliveryNote.where(cart_id:current_cart.id).each do |dn|
      DeliveryNote.soft_delete(dn.id) 
    end
    current_cart.destroy
    session.delete(:cart_id)
    redirect_to [:products]
  end

  private

  def set_payment_provider
    @payment_provider = current_market.payment_provider
  end
end
