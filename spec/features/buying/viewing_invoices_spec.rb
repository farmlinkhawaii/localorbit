require 'spec_helper'

describe "Buyer invoices" do
  let!(:market)    { create(:market, :with_address) }

  let!(:sellers)   { create(:organization, :seller, markets: [market]) }
  let!(:apples)    { create(:product, :sellable, name: "Apples", organization: sellers) }
  let!(:oranges)   { create(:product, :sellable, name: "Oranges", organization: sellers) }
  let!(:grapes)    { create(:product, :sellable, name: "Grapes", organization: sellers) }

  let!(:buyers)    { create(:organization, :buyer, markets: [market]) }

  let!(:others)     { create(:organization, :buyer, markets: [market]) }
  let!(:other_user) { create(:user, organizations: [others]) }

  let!(:ordered_apples1) { create(:order_item, product: apples) }
  let!(:ordered_grapes1) { create(:order_item, product: grapes) }
  let!(:ordered_apples2) { create(:order_item, product: apples) }
  let!(:ordered_grapes2) { create(:order_item, product: grapes) }
  let!(:ordered_apples3) { create(:order_item, product: apples) }
  let!(:ordered_grapes3) { create(:order_item, product: grapes) }

  let!(:invoice_date) { DateTime.parse("April 20, 2014") }
  let!(:invoiced_order) { create(:order, market: market, organization: buyers, items: [ordered_apples1, ordered_grapes1], payment_note: "123456", invoiced_at: invoice_date, invoice_due_date: Date.parse("May 20, 2014")) }
  let!(:invoiced_order2) { create(:order, market: market, organization: buyers, items: [ordered_apples2, ordered_grapes2], payment_note: "77839", invoiced_at: invoice_date, invoice_due_date: Date.parse("May 21, 2014")) }
  let!(:invoiced_order3) { create(:order, market: market, organization: buyers, items: [ordered_apples3, ordered_grapes3], payment_note: "992830", invoiced_at: invoice_date, invoice_due_date: Date.parse("May 23, 2014")) }

  let!(:ordered_oranges)  { create(:order_item, product: oranges) }
  let!(:uninvoiced_order) { create(:order, market: market, organization: buyers, items: [ordered_oranges]) }

  let!(:ordered_oranges2) { create(:order_item, product: oranges) }
  let!(:others_order)     { create(:order, market: market, organization: others, items: [ordered_oranges2], invoiced_at: 2.days.ago, invoice_due_date: 5.days.from_now) }

  context "as a buyer" do
    let!(:user)      { create(:user, organizations: [buyers]) }

    before do
      switch_to_subdomain(market.subdomain)
      sign_in_as(user)

      visit dashboard_path
    end

    it "shows a list of the buyers invoices" do
      click_link "Financials"

      expect(page).to have_content("Financials Overview")
      click_link "Review Invoices"

      expect(page).to have_content("Invoices")

      expect(page).to have_content(invoiced_order.order_number)
      expect(page).to have_content(invoiced_order2.order_number)
      expect(page).to have_content(invoiced_order3.order_number)
      invoices = Dom::Admin::Financials::InvoiceRow.all

      # Ensure no actions are available
      invoices.each do |invoice|
        expect(invoice.action).to be_nil
      end
    end

    it "shows an invoices details page" do
      click_link "Financials"

      expect(page).to have_content("Financials Overview")
      click_link "Review Invoices"

      expect(page).to have_content("Invoices")
      click_link invoiced_order.order_number

      expect(page).to have_content("Due Date")
    end

    context "filter invoices" do
      before do
        click_link "Financials"

        expect(page).to have_content("Financials Overview")
        click_link "Review Invoices"

        expect(page).to have_content(invoiced_order.order_number)
        expect(page).to have_content(invoiced_order2.order_number)
        expect(page).to have_content(invoiced_order3.order_number)
      end

      it "by date" do
        fill_in "q_invoice_due_date_date_gteq", with: "Tue, 21 May 2014"
        click_button "Filter"

        expect(page).not_to have_content(invoiced_order.order_number)
        expect(page).to have_content(invoiced_order2.order_number)
        expect(page).to have_content(invoiced_order3.order_number)

        fill_in "q_invoice_due_date_date_lteq", with: "Tue, 22 May 2014"
        click_button "Filter"

        expect(page).not_to have_content(invoiced_order.order_number)
        expect(page).to have_content(invoiced_order2.order_number)
        expect(page).not_to have_content(invoiced_order3.order_number)
      end

      it "by order number" do
        fill_in "q_order_number_or_payment_note_cont", with: invoiced_order.order_number
        click_button "Filter"

        expect(page).to have_content(invoiced_order.order_number)
        expect(page).not_to have_content(invoiced_order2.order_number)
        expect(page).not_to have_content(invoiced_order3.order_number)
      end

      it "by purchase order" do
        fill_in "q_order_number_or_payment_note_cont", with: "123456"
        click_button "Filter"

        expect(page).to have_content(invoiced_order.order_number)
        expect(page).not_to have_content(invoiced_order2.order_number)
        expect(page).not_to have_content(invoiced_order3.order_number)

        fill_in "q_order_number_or_payment_note_cont", with: "77839"
        click_button "Filter"

        expect(page).not_to have_content(invoiced_order.order_number)
        expect(page).to have_content(invoiced_order2.order_number)
        expect(page).not_to have_content(invoiced_order3.order_number)
      end
    end
  end
end
