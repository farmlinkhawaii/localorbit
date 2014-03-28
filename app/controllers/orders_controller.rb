class OrdersController < ApplicationController
  before_action :hide_admin_navigation

  def create
    @order = Order.create_from_cart(current_cart).decorate
    if @order.persisted?
      current_cart.destroy
      session.delete(:cart_id)
    end
  end
end
