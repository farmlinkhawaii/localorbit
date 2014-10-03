class CrozPdf
  require 'fileutils'
  include FileUtils

  def make_doc(doc_name:"Sample Doc 1", n: 1)
    html = "<html>"
    html << %|<meta charset="utf-8">|
    html << %|<meta name="pdfkit-footer_right" content="Powered by Local Orbit">|
    html << %|<meta name="pdfkit-print_media_type" content="true">|
    html << %|<meta name="pdfkit-header_left" content="Invoice: LO-14-TAHOEFOODHUB-0000022">|
    html << %|<meta name="pdfkit-header_right" content="Page [page] of [toPage]">|
    html << %|<meta name="pdfkit-header_spacing" content="5">|
    html << %|<title>Local Orbit</title>|
    html << "<body>"
    html << "<h1>PDF Generator Test - #{doc_name}</h1>"
    (n*10).times do |i|
      html << "<h2>Section #{i}</h2>"
      html << "<p>This is sample text for section #{i}: Lorem ipsum dolor sit amet, ad duo errem inimicus complectitur, eam eu vide postea inimicus. Diam aliquid at usu, ius animal malorum patrioque cu. Te dicant invenire pro, putant tibique constituam in eam. Vel in adhuc aperiri fierent.</p>"
    end
    html << "</body></html>"
  end

  def mk_pdf(html,fname)
    k = PDFKit.new(html, page_size: "Letter", print_media_type: true)
    k.to_file(fname)
    puts "Wrote #{fname}"
  end

  def run
    mk_pdf(make_doc(doc_name:"Sample 1", n:2), "/tmp/doc1.pdf")
    mk_pdf(make_doc(doc_name:"Sample 2", n:1), "/tmp/doc2.pdf")
    mk_pdf(make_doc(doc_name:"Sample 3", n:3), "/tmp/doc3.pdf")
    outfile = "/tmp/combined.pdf"
    infiles = ["/tmp/doc1.pdf","/tmp/doc2.pdf","/tmp/doc3.pdf"]
    cmd = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dPDFSETTINGS=/prepress -sOutputFile=#{outfile} #{infiles.join(" ")}"
    puts cmd
    system cmd
  end
end
