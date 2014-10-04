module Admin
  class InvoicesController < AdminController
    before_action :fetch_order, except: :spike_generate_batch_invoices

    def show
      @invoice = BuyerOrder.new(@order)
      @market  = @invoice.market.decorate
      @needs_js = true

      render layout: false, locals: { invoice: @invoice, user: current_user }
    end

    def show_pdf
      if @order.invoice_pdf.present?
        redirect_to @order.invoice_pdf.remote_url
      else
        GenerateInvoicePdf.delay.perform(order: @order)
        render "generating"
      end
    end

    def mark_invoiced
      @order.invoice
      head @order.save ? :ok : :not_found
    end

    def spike_generate_batch_invoices
      #orders = Order.uninvoiced.where("placed_at > '2014-09-03'").uninvoiced
      orders = Order.all[-3..-1]

      ctx = SpikeBatchInvoices.perform(user: current_user, orders: orders)
      doc = ctx.doc
      flash[:notice] = "Rock on: #{doc.doc_pdf_uid}/#{doc.doc_pdf_name}"
      redirect_to [:admin, :financials, :invoices]
    end

    private

    def fetch_order
      @order = if current_user.admin? || current_user.market_manager?
        Order.orders_for_buyer(current_user).find(params[:id])
      else
        Order.orders_for_buyer(current_user).invoiced.find(params[:id])
      end
    end
  end
end
