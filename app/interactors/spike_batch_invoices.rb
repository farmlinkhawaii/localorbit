class SpikeBatchInvoices
  include Interactor

  # NEEDS:
  #   orders
  #   user
  # OPTIONAL:
  #   temp_dir
  #
  def perform
    log "Starting batch invoice creation with order ids #{orders.map(&:id).inspect}"

    pdf_temp_files = []
    view = get_action_view
    orders.each do |order|
      invoice = BuyerOrder.new(order)
      fname = "#{tmp}/spike_invoice_#{order.order_number}.pdf"
      html = if context[:test_html] and test_html == true
               generate_testing_html
             else
               generate_html_for_invoice(view,invoice)
             end
      generate_pdf_for_html(html,fname)
      log "Generated PDF invoice #{fname}"
      pdf_temp_files << fname
    end

    big_pdf_fname = merge_pdfs(pdf_temp_files)

    doc = user.documents.create
    doc.doc_pdf = File.read(big_pdf_fname)
    doc.doc_pdf.name = "batch-invoices.pdf"
    doc.save
    context[:doc] = doc
  end

  private
  
  def tmp
    if context[:temp_dir]
      temp_dir
    else
      "/tmp"
    end
  end

  def generate_html_for_invoice(view, invoice)
    view.render( template: "admin/invoices/show.html.erb", locals: { invoice: invoice, user: nil } )
  end

  def generate_testing_html
    File.read("#{Rails.root}/sandbox/one.html")
  end

  def generate_pdf_for_html(html,fname)
    pdf = PDFKit.new(html, page_size: "letter", print_media_type: true)
    pdf.to_file(fname)
  end

  def get_action_view
    action_view = ActionView::Base.new(ActionController::Base.view_paths, {})
    action_view.extend ApplicationHelper
    action_view.class_eval do
      include Rails.application.routes.url_helpers
    end
    action_view
  end

  def merge_pdfs(pdf_temp_files)
    fname = "#{tmp}/spike_batch_invoice_doc.pdf"
    cmd = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dPDFSETTINGS=/prepress -sOutputFile=#{fname} #{pdf_temp_files.join(" ")} 2>&1"
    log "Running: #{cmd}"
    output = `#{cmd}`
    log "Output: #{output}"
    log "Generated #{fname} master invoice"
    fname
  end

  def log(str)
    Rails.logger.info ">> SPIKE BATCH PRINTING: #{str}"
  end

end