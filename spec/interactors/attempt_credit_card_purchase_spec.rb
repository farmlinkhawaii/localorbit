require 'spec_helper'

describe AttemptCreditCardPurchase do
  let!(:user)  { create(:user) }
  let!(:buyer) { create(:organization) }
  let!(:credit_card) { create(:bank_account, :credit_card, bankable: buyer) }
  let!(:cart)  { create(:cart, organization: buyer) }
  let!(:order) { create(:order, total_cost: 199.99) }
  let(:params) { { "payment_method" => "purchase order"} }
  let(:balanced_card) { double("balanced card", hold: true) }

  subject { AttemptCreditCardPurchase.perform(order: order, buyer: user, order_params: params, cart: cart) }

  context "purchase order" do
    let(:params) { { "payment_method" => "purchase order" } }
    it "noop's" do
      expect(subject).to be_success
    end
  end

  context "credit card" do
    let!(:params) { { "payment_method" => "credit card", "credit_card" => "#{credit_card.id}" } }

    before do
      allow(Balanced::Card).to receive(:find).and_return(balanced_card)
    end

    context "valid credit card" do
      context "successfully holds payment" do
        it "sets the payment method on the order" do
          subject

          expect(order.reload.payment_method).to eql("credit card")
        end

        it "creates a hold for the order amount" do
          expect(subject).to be_success
          expect(balanced_card).to have_received(:hold).with(amount: order.total_cost, description: "LocalOrbit market purchase")
        end
      end

      context "fails to hold payment" do
        let!(:balanced_card) { double("balanced card", hold: false) }

        it "returns as a failure" do
          expect(subject).to be_failure
        end

        it "does not modify the order" do
          subject

          expect(order.reload.payment_method).to be_blank
        end
      end
    end

    context "invalid credit card" do
      let!(:params) { { "payment_method" => "credit card", "credit_card" => "0" } }

      it "returns as a failure" do
        expect(subject).to be_failure
      end
    end
  end
end
