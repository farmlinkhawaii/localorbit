require "spec_helper"
include DownloadHelpers

def display_date(date)
  date.strftime("%m/%d/%Y")
end

feature "Reports", js: true do
  let!(:market)    { create(:market, name: "Foo Market", po_payment_term: 30, timezone: "Eastern Time (US & Canada)") }
  let!(:market2)   { create(:market, name: "Bar Market", po_payment_term: 30, timezone: "Eastern Time (US & Canada)") }
  let!(:market3)   { create(:market, name: "Baz Market", po_payment_term: 30, timezone: "Eastern Time (US & Canada)") }
  let!(:buyer)     { create(:organization, name: "Foo Buyer", markets: [market], can_sell: false) }
  let!(:buyer2)    { create(:organization, name: "Bar Buyer", markets: [market2], can_sell: false) }
  let!(:seller)    { create(:organization, name: "Foo Seller", markets: [market], can_sell: true) }
  let!(:seller2)   { create(:organization, name: "Bar Seller", markets: [market2], can_sell: true) }
  let!(:subdomain) { market.subdomain }
  let!(:report)    { :total_sales }
  let!(:delivery_schedule) { create(:delivery_schedule, market: market) }
  let!(:delivery)  { delivery_schedule.next_delivery }
  let!(:order_date) { 3.weeks.ago }

  before do
    delivery_schedule2 = create(:delivery_schedule, market: market2)
    delivery2 = delivery_schedule2.next_delivery
    buyer3 = create(:organization, name: "Baz Buyer", markets: [market3], can_sell: false)

    5.times do |i|
      this_date = order_date + i.days
      Timecop.freeze(this_date) do
        category = create(:category, name: "Category-01-#{i}")
        product = create(:product,
                         :sellable,
                         name: "Product#{i}",
                         category: category,
                         organization: seller)
        order_item = create(:order_item,
                            product: product,
                            seller_name: seller.name,
                            unit_price: 20.00 + i, quantity: 1,
                            market_seller_fee: 0.50,
                            payment_seller_fee: 1.25,
                            local_orbit_seller_fee: 1.50
                           )
        order = create(:order,
                       market_id: market.id,
                       delivery: delivery,
                       items: [order_item],
                       organization: buyer,
                       payment_method: ["purchase order", "purchase order", "purchase order", "ach", "ach", "credit card"][i],
                       payment_status: "paid",
                       order_number: "LO-01-234-4567890-#{i}")
        create(:payment,
               payment_method: ["cash", "check", "ach", "ach", "credit card"][i],
               payer: buyer,
               payee: market,
               orders: [order],
               amount: order.total_cost)

        category = create(:category, name: "Category-02-#{i}")
        product = create(:product,
                         :sellable,
                         name: "Product#{i}",
                         category: category,
                         organization: seller2)
        order_item = create(:order_item,
                            product: product,
                            seller_name: seller2.name,
                            unit_price: 20.00 + i, quantity: 1)
        create(:order,
               market_id: market2.id,
               delivery: delivery2,
               items: [order_item],
               organization: buyer2,
               payment_method: ["purchase order", "purchase order", "purchase order", "ach", "ach", "credit card"][i],
               payment_status: "paid",
               order_number: "LO-02-234-4567890-#{i}")
      end
    end

    this_date = order_date - 1.day
    order_item = create(:order_item,
                        created_at: this_date,
                        seller_name: "Seller-03-1",
                        unit_price: 301, quantity: 1)
    create(:order,
           placed_at: this_date,
           delivery: delivery,
           items: [order_item],
           organization: buyer3,
           payment_method: "credit card",
           payment_status: "unpaid",
           order_number: "LO-03-234-4567890-1")

    # Order outside of default date range
    older_date = 5.weeks.ago
    create(:order,
           placed_at: older_date,
           delivery: delivery,
           items: [create(:order_item, created_at: older_date)],
           organization: buyer3,
           payment_method: "credit card",
           payment_status: "unpaid",
           order_number: "LO-03-234-4567890-2")

    switch_to_subdomain(subdomain)
    sign_in_as(user)
    visit_report_view
  end

  def visit_report_view
    click_link "Reports", match: :first
    within("#reports-dropdown") do
      click_link "Reports"
    end
  end

  def select_report
    report_title = report.to_s.titleize
    select report_title, from: "Report type"
    wait_for { current_path }.to eq(admin_report_path(report.to_s.dasherize))
  end

  def expect_item_rows_for_order(order, count)
    wait_for {
      Dom::Report::ItemRow.all.select { |row| row.order_number.include?("#{order}") }.count
    }.to eq(count)
  end

  context "for all reports" do
    context "as a user in only 1 market" do
      let!(:user) { create(:user, :market_manager, managed_markets: [market])}

      scenario "does not display the market filter" do
        expect(page).to have_field("Search")
        expect(page).to have_field("Placed on or after")
        expect(page).to have_field("Placed on or before")
        expect(page).not_to have_select("Market")
      end
    end

    context "as any user" do
      let!(:user)   { create(:user, :admin) }
      let!(:report) { :total_sales }

      before do
        select_report
      end

      scenario "date range defaults to last 30 days and can filter results" do
        sleep 1 # just gotta sleep a little bit to make these work…
        expect_item_rows_for_order("LO-01-234-4567890-0", 1)
        expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        expect_item_rows_for_order("LO-01-234-4567890-2", 1)
        expect_item_rows_for_order("LO-01-234-4567890-3", 1)
        expect_item_rows_for_order("LO-01-234-4567890-4", 1)
        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 1)
        expect_item_rows_for_order("LO-02-234-4567890-4", 1)
        expect_item_rows_for_order("LO-03-234-4567890-1", 1)
        expect_item_rows_for_order("LO-03-234-4567890-2", 0)

        # Because Javascript. And datepickers. But mostly Javascript.
        page.execute_script("$('#q_order_placed_at_date_gteq').datepicker('setDate', '#{6.weeks.ago.strftime("%d %b %Y")}')")

        click_button "Filter"

        expect_item_rows_for_order("LO-01-234-4567890-0", 1)
        expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        expect_item_rows_for_order("LO-01-234-4567890-2", 1)
        expect_item_rows_for_order("LO-01-234-4567890-3", 1)
        expect_item_rows_for_order("LO-01-234-4567890-4", 1)
        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 1)
        expect_item_rows_for_order("LO-02-234-4567890-4", 1)
        expect_item_rows_for_order("LO-03-234-4567890-1", 1)
        expect_item_rows_for_order("LO-03-234-4567890-2", 1)

        # Because Javascript. And datepickers. But mostly Javascript.
        page.execute_script("$('#q_order_placed_at_date_lteq').datepicker('setDate', '#{(order_date + 2.days).strftime("%d %b %Y")}')")
        
        click_button "Filter"

        expect_item_rows_for_order("LO-01-234-4567890-0", 1)
        expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        expect_item_rows_for_order("LO-01-234-4567890-2", 1)
        expect_item_rows_for_order("LO-01-234-4567890-3", 0)
        expect_item_rows_for_order("LO-01-234-4567890-4", 0)
        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 0)
        expect_item_rows_for_order("LO-02-234-4567890-4", 0)
        expect_item_rows_for_order("LO-03-234-4567890-1", 1)
        expect_item_rows_for_order("LO-03-234-4567890-2", 1)
      end

      scenario "displays the appropriate filters" do
        expect(page).to have_field("Search")
        expect(page).to have_field("Placed on or after")
        expect(page).to have_field("Placed on or before")
        expect(page).to have_select("Market")
      end

      scenario "searches by order number" do
        wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

        fill_in "Search", with: "LO-02"
        click_button "Search"

        wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 1)
        expect_item_rows_for_order("LO-02-234-4567890-4", 1)

        fill_in "Search", with: "LO-03"
        click_button "Search"

        wait_for { Dom::Report::ItemRow.all.count }.to eq(1)
        expect_item_rows_for_order("LO-03-234-4567890-1", 1)
      end

      scenario "filters by market" do
        wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

        select market.name, from: "Market"
        click_button "Filter"

        wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
        expect_item_rows_for_order("LO-01-234-4567890-0", 1)
        expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        expect_item_rows_for_order("LO-01-234-4567890-2", 1)
        expect_item_rows_for_order("LO-01-234-4567890-3", 1)
        expect_item_rows_for_order("LO-01-234-4567890-4", 1)

        select market2.name, from: "Market"
        click_button "Filter"

        wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 1)
        expect_item_rows_for_order("LO-02-234-4567890-4", 1)
      end

      context "can download a CSV", driver: :ff_csv do
        scenario "of report" do
          items = Dom::Report::ItemRow.all
          html_headers = page.all(".report-table .stickable th").map(&:text)

          expect(items.count).to eq(11)

          click_link "Export CSV"

          csv = CSV.read(download, headers: true)

          expect(csv.count).to eq(items.count)

          # Ensure we see the same columns and order in HTML and CSV
          expect(html_headers - csv.headers).to be_empty

          # For all fields defined for the current report, ensure we have
          # corresponding values in our CSV file. Fields for a given report
          # are defined in ReportPresenter.
          field_headers = ReportPresenter.field_headers_for_report(report)
          items.each_with_index do |item, i|
            field_headers.each_pair do |field, display_name|
              expect(item.send(field)).to include(csv[i][display_name])
            end
          end
        end

        scenario "of all records irrespective of pagination" do
          category = create(:category)
          product = create(:product,
                           :sellable,
                           category: category,
                           organization: seller)
          order_items = create_list(:order_item, 20, product: product, seller_name: seller.name)
          order_items.each do |order_item|
            create(:order,
                  market_id: market.id,
                  delivery: delivery,
                  items: [order_item],
                  organization: buyer)
          end

          visit(current_path + "?per_page=25")

          # paginates to 25
          wait_for { Dom::Report::ItemRow.all.count }.to eq(25)

          click_link "Export CSV"

          csv = CSV.read(download, headers: true)

          expect(csv.count).to eq(31) # 11 + 20
        end
      end

      context "Sales by Seller report" do
        let!(:report) { :sales_by_seller }

        before do
          select_report
        end

        scenario "displays the appropriate filters" do
          expect(page).to have_field("Search")
          expect(page).to have_field("Placed on or after")
          expect(page).to have_field("Placed on or before")
          expect(page).to have_select("Market")
          expect(page).to have_select("Seller")
        end

        scenario "displays total sales" do
          totals = Dom::Admin::TotalSales.first

          expect(totals.gross_sales).to eq("$521.00")
          expect(totals.market_fees).to eq("$2.50")
          expect(totals.lo_fees).to eq("$7.50")
          expect(totals.processing_fees).to eq("$6.25")
          expect(totals.discounts).to eq("$0.00")
          expect(totals.net_sales).to eq("$504.75")
        end

        scenario "filters by seller" do
          expect(page).to have_content("Seller")
          wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

          select seller.name, from: "Seller"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
          expect_item_rows_for_order("LO-01-234-4567890-0", 1)
          expect_item_rows_for_order("LO-01-234-4567890-1", 1)
          expect_item_rows_for_order("LO-01-234-4567890-2", 1)
          expect_item_rows_for_order("LO-01-234-4567890-3", 1)
          expect_item_rows_for_order("LO-01-234-4567890-4", 1)

          select seller2.name, from: "Seller"
          click_button "Filter"

          sleep 1

          wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
          expect_item_rows_for_order("LO-02-234-4567890-0", 1)
          expect_item_rows_for_order("LO-02-234-4567890-1", 1)
          expect_item_rows_for_order("LO-02-234-4567890-2", 1)
          expect_item_rows_for_order("LO-02-234-4567890-3", 1)
          expect_item_rows_for_order("LO-02-234-4567890-4", 1)
        end
      end

      context "Sales by Buyer report" do
        let!(:report) { :sales_by_buyer }

        before do
          select_report
        end

        scenario "displays the appropriate filters" do
          expect(page).to have_field("Search")
          expect(page).to have_field("Placed on or after")
          expect(page).to have_field("Placed on or before")
          expect(page).to have_select("Market")
        end

        scenario "displays total sales" do
          totals = Dom::Admin::TotalSales.first

          expect(totals.gross_sales).to eq("$521.00")
          expect(totals.market_fees).to eq("$2.50")
          expect(totals.lo_fees).to eq("$7.50")
          expect(totals.processing_fees).to eq("$6.25")
          expect(totals.discounts).to eq("$0.00")
          expect(totals.net_sales).to eq("$504.75")
        end

        scenario "filters by buyer" do
          wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

          select buyer.name, from: "Buyer"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
          expect_item_rows_for_order("LO-01-234-4567890-0", 1)
          expect_item_rows_for_order("LO-01-234-4567890-1", 1)
          expect_item_rows_for_order("LO-01-234-4567890-2", 1)
          expect_item_rows_for_order("LO-01-234-4567890-3", 1)
          expect_item_rows_for_order("LO-01-234-4567890-4", 1)

          select buyer2.name, from: "Buyer"
          click_button "Filter"

          sleep 1

          wait_for { Dom::Report::ItemRow.all.count }.to eq(5)
          expect_item_rows_for_order("LO-02-234-4567890-0", 1)
          expect_item_rows_for_order("LO-02-234-4567890-1", 1)
          expect_item_rows_for_order("LO-02-234-4567890-2", 1)
          expect_item_rows_for_order("LO-02-234-4567890-3", 1)
          expect_item_rows_for_order("LO-02-234-4567890-4", 1)
        end
      end

      context "Sales by Product report" do
        let!(:report) { :sales_by_product }

        before do
          select_report
        end

        scenario "displays the appropriate filters" do
          expect(page).to have_field("Search")
          expect(page).to have_field("Placed on or after")
          expect(page).to have_field("Placed on or before")
          expect(page).to have_select("Market")
          expect(page).to have_select("Category")
          expect(page).to have_select("Product")
        end

        scenario "displays total sales" do
          totals = Dom::Admin::TotalSales.first

          expect(totals.gross_sales).to eq("$521.00")
          expect(totals.market_fees).to eq("$2.50")
          expect(totals.lo_fees).to eq("$7.50")
          expect(totals.processing_fees).to eq("$6.25")
          expect(totals.discounts).to eq("$0.00")
          expect(totals.net_sales).to eq("$504.75")
        end

        scenario "filters by category" do
          wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

          select "Category-01-0", from: "Category"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(1)
          expect_item_rows_for_order("LO-01-234-4567890-0", 1)

          select "Category-01-1", from: "Category"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(1)
          expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        end

        scenario "filters by product" do
          wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

          select "Product0", from: "Product"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(2)
          expect_item_rows_for_order("LO-01-234-4567890-0", 1)
          expect_item_rows_for_order("LO-02-234-4567890-0", 1)

          select "Product1", from: "Product"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(2)
          expect_item_rows_for_order("LO-01-234-4567890-1", 1)
          expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        end
      end

      context "Sales by Payment Method report" do
        let!(:report) { :sales_by_payment_method }

        before do
          select_report
        end

        scenario "displays the appropriate filters" do
          expect(page).to have_field("Search")
          expect(page).to have_field("Placed on or after")
          expect(page).to have_field("Placed on or before")
          expect(page).to have_select("Market")
          expect(page).to have_select("Payment Method")
        end

        scenario "displays total sales" do
          totals = Dom::Admin::TotalSales.first

          expect(totals.gross_sales).to eq("$521.00")
          expect(totals.market_fees).to eq("$2.50")
          expect(totals.lo_fees).to eq("$7.50")
          expect(totals.processing_fees).to eq("$6.25")
          expect(totals.discounts).to eq("$0.00")
          expect(totals.net_sales).to eq("$504.75")
        end

        scenario "filters by payment method" do
          wait_for { Dom::Report::ItemRow.all.count }.to eq(11)

          select "ACH", from: "Payment Method"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(4)
          expect_item_rows_for_order("LO-01-234-4567890-3", 1)
          expect_item_rows_for_order("LO-02-234-4567890-3", 1)
          expect_item_rows_for_order("LO-01-234-4567890-4", 1)
          expect_item_rows_for_order("LO-02-234-4567890-4", 1)

          select "Purchase Order", from: "Payment Method"
          click_button "Filter"

          wait_for { Dom::Report::ItemRow.all.count }.to eq(6)
          expect_item_rows_for_order("LO-01-234-4567890-0", 1)
          expect_item_rows_for_order("LO-02-234-4567890-0", 1)
          expect_item_rows_for_order("LO-01-234-4567890-1", 1)
          expect_item_rows_for_order("LO-02-234-4567890-1", 1)
          expect_item_rows_for_order("LO-01-234-4567890-2", 1)
          expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        end
      end
    end

    context "as an Admin" do
      let!(:user) { create(:user, :admin) }

      it "shows the appropriate order items" do
        items = Dom::Report::ItemRow.all

        expect(items.count).to eq(11)

        # default sort order is placed_at descending
        expect(items[0].order_date).to eq(display_date(order_date + 4.days))
        expect(items[1].order_date).to eq(display_date(order_date + 4.days))
        expect(items[2].order_date).to eq(display_date(order_date + 3.days))
        expect(items[3].order_date).to eq(display_date(order_date + 3.days))
        expect(items[4].order_date).to eq(display_date(order_date + 2.days))
        expect(items[5].order_date).to eq(display_date(order_date + 2.days))
        expect(items[6].order_date).to eq(display_date(order_date + 1.day))
        expect(items[7].order_date).to eq(display_date(order_date + 1.day))
        expect(items[8].order_date).to eq(display_date(order_date))
        expect(items[9].order_date).to eq(display_date(order_date))
        expect(items[10].order_date).to eq(display_date(order_date - 1.day))

        expect_item_rows_for_order("LO-01-234-4567890-0", 1)
        expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        expect_item_rows_for_order("LO-01-234-4567890-2", 1)
        expect_item_rows_for_order("LO-01-234-4567890-3", 1)
        expect_item_rows_for_order("LO-01-234-4567890-4", 1)
        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 1)
        expect_item_rows_for_order("LO-02-234-4567890-4", 1)
        expect_item_rows_for_order("LO-03-234-4567890-1", 1)
      end
    end

    context "as a Market Manager" do
      let!(:user) { create(:user, managed_markets: [market]) }

      it "shows the appropriate order items" do
        items = Dom::Report::ItemRow.all

        expect(items.count).to eq(5)

        # default sort order is placed_at descending
        expect(items[0].order_date).to eq(display_date(order_date + 4.days))
        expect(items[1].order_date).to eq(display_date(order_date + 3.days))
        expect(items[2].order_date).to eq(display_date(order_date + 2.days))
        expect(items[3].order_date).to eq(display_date(order_date + 1.days))
        expect(items[4].order_date).to eq(display_date(order_date))

        expect_item_rows_for_order("LO-01-234-4567890-0", 1)
        expect_item_rows_for_order("LO-01-234-4567890-1", 1)
        expect_item_rows_for_order("LO-01-234-4567890-2", 1)
        expect_item_rows_for_order("LO-01-234-4567890-3", 1)
        expect_item_rows_for_order("LO-01-234-4567890-4", 1)
      end

      context "who deletes an organization" do
        it "shows the appropriate order items" do
          delete_organization(buyer)
          delete_organization(seller)

          visit_report_view

          items = Dom::Report::ItemRow.all

          expect(items.count).to eq(5)

          # default sort order is placed_at descending
          expect(items[0].order_date).to eq(display_date(order_date + 4.days))
          expect(items[1].order_date).to eq(display_date(order_date + 3.days))
          expect(items[2].order_date).to eq(display_date(order_date + 2.days))
          expect(items[3].order_date).to eq(display_date(order_date + 1.days))
          expect(items[4].order_date).to eq(display_date(order_date))

          expect_item_rows_for_order("LO-01-234-4567890-0", 1)
          expect_item_rows_for_order("LO-01-234-4567890-1", 1)
          expect_item_rows_for_order("LO-01-234-4567890-2", 1)
          expect_item_rows_for_order("LO-01-234-4567890-3", 1)
          expect_item_rows_for_order("LO-01-234-4567890-4", 1)
        end
      end
    end

    context "as a Seller" do
      let!(:user)      { create(:user, organizations: [seller2]) }
      let!(:subdomain) { market2.subdomain }

      it "shows the appropriate order items" do
        items = Dom::Report::ItemRow.all

        expect(items.count).to eq(5)

        # default sort order is placed_at descending
        expect(items[0].order_date).to eq(display_date(order_date + 4.days))
        expect(items[1].order_date).to eq(display_date(order_date + 3.days))
        expect(items[2].order_date).to eq(display_date(order_date + 2.days))
        expect(items[3].order_date).to eq(display_date(order_date + 1.days))
        expect(items[4].order_date).to eq(display_date(order_date))

        expect_item_rows_for_order("LO-02-234-4567890-0", 1)
        expect_item_rows_for_order("LO-02-234-4567890-1", 1)
        expect_item_rows_for_order("LO-02-234-4567890-2", 1)
        expect_item_rows_for_order("LO-02-234-4567890-3", 1)
        expect_item_rows_for_order("LO-02-234-4567890-4", 1)
      end

      context "with purchases" do
        let!(:order)     { create(:order, :with_items, organization: seller2) }

        before do
          visit_report_view
        end

        context "Purchases by Product report" do
          let!(:report) { :purchases_by_product }

          before do
            select_report
          end

          # Filters are reused from other reports so we just need to ensure
          # the right ones show on the page.
          scenario "displays the appropriate filters" do
            expect(page).to have_field("Search")
            expect(page).to have_field("Placed on or after")
            expect(page).to have_field("Placed on or before")
            expect(page).to have_select("Category")
            expect(page).to have_select("Product")
          end

          scenario "displays total sales" do
            
            totals = Dom::Admin::TotalSales.first

            expect(totals.gross_sales).to eq("$6.99")
            expect(totals.market_fees).to eq("$0.00")
            expect(totals.lo_fees).to eq("$0.00")
            expect(totals.processing_fees).to eq("$0.00")
            expect(totals.discounts).to eq("$0.00")
            expect(totals.net_sales).to eq("$6.99")
          end
        end

        context "Total Purchases report" do
          let!(:report) { :total_purchases }

          before do
            select_report
          end

          # Filters are reused from other reports so we just need to ensure
          # the right ones show on the page.
          scenario "displays the appropriate filters" do
            expect(page).to have_field("Search")
            expect(page).to have_field("Placed on or after")
            expect(page).to have_field("Placed on or before")
          end

          scenario "displays total sales" do
            
            totals = Dom::Admin::TotalSales.first

            expect(totals.gross_sales).to eq("$6.99")
            expect(totals.market_fees).to eq("$0.00")
            expect(totals.lo_fees).to eq("$0.00")
            expect(totals.processing_fees).to eq("$0.00")
            expect(totals.discounts).to eq("$0.00")
            expect(totals.net_sales).to eq("$6.99")
          end
        end
      end

    end

    context "as a Buyer" do
      let!(:user)      { create(:user, organizations: [buyer]) }

      context "Purchases by Product report" do
        let!(:report) { :purchases_by_product }

        before do
          select_report
        end

        # Filters are reused from other reports so we just need to ensure
        # the right ones show on the page.
        scenario "displays the appropriate filters" do
          expect(page).to have_field("Search")
          expect(page).to have_field("Placed on or after")
          expect(page).to have_field("Placed on or before")
          expect(page).to have_select("Category")
          expect(page).to have_select("Product")
        end

        scenario "displays total sales" do
          totals = Dom::Admin::TotalSales.first

          expect(totals.gross_sales).to eq("$110.00")
          expect(totals.market_fees).to eq("$2.50")
          expect(totals.lo_fees).to eq("$7.50")
          expect(totals.processing_fees).to eq("$6.25")
          expect(totals.discounts).to eq("$0.00")
          expect(totals.net_sales).to eq("$93.75")
        end
      end

      context "Total Purchases report" do
        let!(:report) { :total_purchases }

        before do
          select_report
        end

        # Filters are reused from other reports so we just need to ensure
        # the right ones show on the page.
        scenario "displays the appropriate filters" do
          expect(page).to have_field("Search")
          expect(page).to have_field("Placed on or after")
          expect(page).to have_field("Placed on or before")
        end

        scenario "displays total sales" do
          totals = Dom::Admin::TotalSales.first

          expect(totals.gross_sales).to eq("$110.00")
          expect(totals.market_fees).to eq("$2.50")
          expect(totals.lo_fees).to eq("$7.50")
          expect(totals.processing_fees).to eq("$6.25")
          expect(totals.discounts).to eq("$0.00")
          expect(totals.net_sales).to eq("$93.75")
        end
      end
    end
  end
end
