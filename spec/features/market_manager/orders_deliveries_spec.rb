require "spec_helper"

context "Viewing sold items" do
  let(:market) { create(:market) }

  let!(:buyer) { create(:organization, :buyer, name: "Big Money", markets: [market]) }
  let!(:seller) { create(:organization, :seller, name: "Good foodz", markets: [market]) }
  let!(:seller2) { create(:organization, :seller, name: "Better foodz", markets: [market]) }
  let!(:product1) { create(:product, :sellable, name: "Green things", organization: seller) }
  let!(:product2) { create(:product, :sellable, name: "Purple cucumbers", organization: seller) }
  let!(:product3) { create(:product, :sellable, name: "Brocolli", organization: seller2) }
  let!(:delivery_schedule) { create(:delivery_schedule, market: market) }
  let!(:delivery) { create(:delivery, delivery_schedule: delivery_schedule) }
  let!(:order_items) {
    [
      create(:order_item, product: product1, seller_name: seller.name, name: product1.name, unit_price: 6.50, quantity: 5, unit: "Bushels"),
      create(:order_item, product: product2, seller_name: seller.name, name: product2.name, unit_price: 5.00, quantity: 10, unit: "Lots"),
      create(:order_item, product: product3, seller_name: seller2.name, name: product3.name, unit_price: 2.00, quantity: 12, unit: "Heads")
    ]
  }

  let!(:order) { create(:order, items: order_items, organization: buyer, market: market, delivery: delivery, order_number: "LO-ADA-0000001") }

  before(:each) do
    switch_to_subdomain(market.subdomain)
  end

  context "as a market manager" do
    let(:market_manager) { create :user, managed_markets: [market] }

    before do
      sign_in_as market_manager
      visit admin_order_items_path
    end

    it "lists all sold items for the market" do
      sold_items = Dom::Admin::SoldItemRow.all

      expect(sold_items.count).to eq(3)

      sold_item = Dom::Admin::SoldItemRow.first

      expect(sold_item.order_number).to have_content("LO-ADA-0000001")
      expect(sold_item.order_date).to eq(order.placed_at.strftime("%m/%d/%Y"))
      expect(sold_item.buyer).to eq("Big Money")
      expect(sold_item.seller).to eq("Better foodz")
      expect(sold_item.product).to eq("Brocolli")
      expect(sold_item.quantity).to eq("12")
      expect(sold_item.total_price).to eq("$24.00")
      expect(sold_item.unit_price).to eq("$2.00/Heads")
      expect(sold_item.delivery_status).to eq("Pending")
      expect(sold_item.buyer_payment_status).to eq("Unpaid")
      expect(sold_item.seller_payment_status).to eq("Unpaid")
    end

    it "lists by default items sold within the last month" do
      order_item = create(:order_item, product: product2, seller_name: seller.name, name: product2.name, created_at: 5.weeks.ago )
      order = create(:order, items: [order_item], organization: buyer, market: market, order_number: "LO-ADA-0000002", delivery: delivery, created_at: 5.weeks.ago, placed_at: 5.weeks.ago)

      expect(Dom::Admin::SoldItemRow.count).to eq(3)

      fill_in "q_created_at_date_gteq", with: 6.weeks.ago.to_date.to_s
      click_button "Filter"

      expect(Dom::Admin::SoldItemRow.count).to eq(4)
    end

    it "shows the correct search and filters" do
      has_field?("Search")
      has_select?("Market")
      has_select?("Seller")
      has_select?("Buyer")
      has_select?("Delivery Status")
      has_select?("Buyer Payment Status")
      # has_select?("Seller Payment Status") # TODO: Add this
      has_field?("Placed on or after")
      has_field?("Placed on or before")
    end

    it "lists all sold items for the market as a CSV" do
      html_headers = page.all('th').map(&:text)[1..-1] # remove checkbox column
      click_link "Export CSV"
      csv_headers = CSV.parse(page.body).first
      expect(html_headers - csv_headers).to be_empty # CSV expands stacked columns for order date, market, and unit price
      expect(page).to have_content("LO-ADA-0000001")
    end

    context "when the market manager has deleted the seller" do
      before do
        delete_organization(seller)
        delete_organization(seller2)
        visit admin_order_items_path
      end

      it "lists all sold items for the market" do
        sold_items = Dom::Admin::SoldItemRow.all

        expect(sold_items.count).to eq(3)

        sold_item = Dom::Admin::SoldItemRow.first

        expect(sold_item.order_number).to have_content("LO-ADA-0000001")
        expect(sold_item.order_date).to eq("03/15/2014")
        expect(sold_item.buyer).to eq("Big Money")
        expect(sold_item.seller).to eq("Better foodz")
        expect(sold_item.product).to eq("Brocolli")
        expect(sold_item.quantity).to eq("12")
        expect(sold_item.total_price).to eq("$24.00")
        expect(sold_item.unit_price).to eq("$2.00/Heads")
        expect(sold_item.delivery_status).to eq("Pending")
        expect(sold_item.buyer_payment_status).to eq("Unpaid")
        expect(sold_item.seller_payment_status).to eq("Unpaid")
      end
    end

      it "shows the correct search and filters" do
        has_field?("Search")
        has_select?("Market")
        has_select?("Seller")
        has_select?("Buyer")
        has_select?("Delivery Status")
        has_select?("Buyer Payment Status")
        # has_select?("Seller Payment Status") # TODO: Add this
        has_field?("Placed on or after")
        has_field?("Placed on or before")
      end

      it "lists all sold items for the market as a CSV" do
        html_headers = page.all('#sold-items th').map(&:text)[1..-1] # remove checkbox column
        click_link "Export CSV"
        csv_headers = CSV.parse(page.body).first
        expect(html_headers - csv_headers).to be_empty # CSV expands stacked columns for order date, market, and unit price
        expect(page).to have_content("LO-ADA-0000001")
      end

      it "sets item delivery status" do
        expect(UpdateBalancedPurchase).to receive(:perform).twice.and_return(double("interactor", success?: true))

        sold_item = Dom::Admin::SoldItemRow.first
        sold_item.select
        select 'Delivered', from: 'delivery_status'
        click_button 'Apply Action'

        sold_items = Dom::Admin::SoldItemRow.all
        expect(sold_items[0].delivery_status).to eq("Delivered")
        expect(sold_items[1].delivery_status).to eq("Pending")
        expect(sold_items[2].delivery_status).to eq("Pending")

        Dom::Admin::SoldItemRow.all.each(&:select)
        select 'Delivered', from: 'delivery_status'
        click_button 'Apply Action'

        sold_items = Dom::Admin::SoldItemRow.all
        expect(sold_items[0].delivery_status).to eq("Delivered")
        expect(sold_items[1].delivery_status).to eq("Delivered")
        expect(sold_items[2].delivery_status).to eq("Delivered")
      end

      it "cancels an item from an order" do
        expect(UpdateBalancedPurchase).to receive(:perform).and_return(double("interactor", success?: true))
        expect(order.total_cost.to_f).to eql(106.50)

        sold_item = Dom::Admin::SoldItemRow.first
        sold_item.select
        select 'Canceled', from: 'delivery_status'
        click_button 'Apply Action'

        expect(order.reload.total_cost.to_f).to eql(82.50)
        sold_items = Dom::Admin::SoldItemRow.all
        expect(sold_items[0].delivery_status).to eq("Canceled")
        expect(sold_items[1].delivery_status).to eq("Pending")
        expect(sold_items[2].delivery_status).to eq("Pending")
      end

      it "displays sales totals for all pages of filtered results" do
        expect(page).to have_content("Total Sales")
        totals = Dom::Admin::TotalSales.first

        expect(totals.gross_sales).to eq("$106.50")
        expect(totals.market_fees).to eq("$0.75")
        expect(totals.lo_fees).to eq("$4.00")
        expect(totals.processing_fees).to eq("$1.20")
        expect(totals.discounts).to eq("$0.00")
        expect(totals.net_sales).to eq("$100.55")

        select seller.name, from: "q_product_organization_id_eq"
        click_button "Filter"

        totals = Dom::Admin::TotalSales.first

        expect(totals.gross_sales).to eq("$82.50")
        expect(totals.market_fees).to eq("$0.75")
        expect(totals.lo_fees).to eq("$0.00")
        expect(totals.processing_fees).to eq("$1.20")
        expect(totals.discounts).to eq("$0.00")
        expect(totals.net_sales).to eq("$80.55")
      end
    end

    it "sets item delivery status" do
      expect(UpdateBalancedPurchase).to receive(:perform).twice.and_return(double("interactor", success?: true))

      sold_item = Dom::Admin::SoldItemRow.first
      sold_item.select
      select 'Delivered', from: 'delivery_status'
      click_button 'Apply Action'

      sold_items = Dom::Admin::SoldItemRow.all
      expect(sold_items[0].delivery_status).to eq("Delivered")
      expect(sold_items[1].delivery_status).to eq("Pending")
      expect(sold_items[2].delivery_status).to eq("Pending")

      Dom::Admin::SoldItemRow.all.each(&:select)
      select 'Delivered', from: 'delivery_status'
      click_button 'Apply Action'

      sold_items = Dom::Admin::SoldItemRow.all
      expect(sold_items[0].delivery_status).to eq("Delivered")
      expect(sold_items[1].delivery_status).to eq("Delivered")
      expect(sold_items[2].delivery_status).to eq("Delivered")
    end

    it "cancels an item from an order" do
      expect(UpdateBalancedPurchase).to receive(:perform).and_return(double("interactor", success?: true))
      expect(order.total_cost.to_f).to eql(106.50)

      sold_item = Dom::Admin::SoldItemRow.first
      sold_item.select
      select 'Canceled', from: 'delivery_status'
      click_button 'Apply Action'

      expect(order.reload.total_cost.to_f).to eql(82.50)
      sold_items = Dom::Admin::SoldItemRow.all
      expect(sold_items[0].delivery_status).to eq("Canceled")
      expect(sold_items[1].delivery_status).to eq("Pending")
      expect(sold_items[2].delivery_status).to eq("Pending")
    end
  end

  context "as a seller" do
    let(:user) { create(:user, organizations: [seller]) }

    before do
      sign_in_as user
      visit admin_order_items_path
    end

    it "lists all sold items for the seller organization" do
      sold_items = Dom::Admin::SoldItemRow.all

      expect(sold_items.count).to eq(2)

      sold_item = Dom::Admin::SoldItemRow.first

      expect(sold_item.order_number).to have_content("LO-ADA-0000001")
      expect(sold_item.order_date).to eq(order.placed_at.strftime("%m/%d/%Y"))
      expect(sold_item.buyer).to eq("Big Money")
      expect(sold_item.seller).to eq("Good foodz")
      expect(sold_item.product).to eq("Green things")
      expect(sold_item.quantity).to eq("5")
      expect(sold_item.total_price).to eq("$32.50")
      expect(sold_item.unit_price).to eq("$6.50/Bushels")
      expect(sold_item.delivery_status).to eq("Pending")
      expect(sold_item.buyer_payment_status).to eq("Unpaid")
      expect(sold_item.seller_payment_status).to eq("Unpaid")
    end
  end
end
