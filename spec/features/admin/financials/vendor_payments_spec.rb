require 'spec_helper'

feature 'Record payments to suppliers', :js  do

  include_context 'the mini market'
  include_context 'second market'

  let!(:order3_item1) { create(:order_item, product: sally_product1, unit_price: 9.99) }
  let!(:order3) { create(:order, placed_at: 4.days.ago, items: [order3_item1], market: second_market, organization: buyer2_organization) }
  let!(:order4_item1) { create(:order_item, product: sally_product2, unit_price: 9.99) }
  let!(:order4) { create(:order, placed_at: 4.days.ago, items: [order4_item1], market: second_market, organization: buyer2_organization) }

  before do
    second_market.managers << mary
    mary.organizations << second_market.organization
    second_market.organizations << seller_organization
    SetOrderItemsStatus.perform(
      user: mary,
      order_item_ids: [order1_item1.id, order2_item1.id, order3_item1.id, order4_item1.id],
      delivery_status: 'delivered'
    )
    switch_to_subdomain mini_market.subdomain
    sign_in_as mary
  end

  it 'displays all sellers to whom a managed market owes payment' do
    visit admin_financials_vendor_payments_path

    expect(page).to have_content('Record Payments to Suppliers')
    expect(page).to have_content("Sally's Staples")
    expect(page).to have_content('2 orders from Mini Market')
    expect(page).to have_content('$13.98')

    expect(page).to have_content('2 orders from Second Market')
    expect(page).to have_content('$19.98')
  end

  it 'allows complete payment of all unpaid orders for seller within a market' do
    visit admin_financials_vendor_payments_path

    first('.pay-all-now').click
    expect(page).to have_content('Cash')
    first('.payment-types').choose('Check')
    first('.check').fill_in('Check #', with: '123')
    first('.record-payment').click_button('Record Payment')
    expect(page).to have_content("Payment of $13.98 recorded for Sally's Staples")
  end

  it 'allows partial payment of some unpaid orders for seller within a market' do
    visit admin_financials_vendor_payments_path

    first('.review-orders').click
    expect(page).to have_content('Hide Orders')
    expect(page).to have_content(order1.order_number)
    expect(first('.line-total')).to have_content('$6.99')
    expect(page).to have_content(order2.order_number)
    first('.payment-order').uncheck('payment_order_ids_')
    expect(first('.total-owed')).to have_content('$6.99')

    first('.pay-selected-now').click
    expect(page).to have_content('Cash')
    first('.payment-types').choose('Check')
    first('.check').fill_in('Check #', with: '123')
    first('.record-payment').click_button('Record Payment')
    expect(page).to have_content("Payment of $6.99 recorded for Sally's Staples")
  end

  it 'uses sticky filter params when scoping orders' do
    visit admin_financials_vendor_payments_path

    expect(page).to have_selector('.vendor-payment', count: 2)
    fill_in('q_placed_at_date_gteq', with: 2.days.ago.strftime("%Y-%m-%d"))
    click_on('Filter')
    # filter works?
    expect(page).to have_selector('.vendor-payment', count: 1)
    # sticky filter works?
    visit admin_financials_vendor_payments_path
    expect(page).to have_selector('.vendor-payment', count: 1)
  end

end
