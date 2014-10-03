def make_doc
  doc_name = "sample doc 1"
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
  20.times do |i|
    html << "<h2>Section #{i}</h2>"
    html << "<p>This is sample text for section #{i}: Lorem ipsum dolor sit amet, ad duo errem inimicus complectitur, eam eu vide postea inimicus. Diam aliquid at usu, ius animal malorum patrioque cu. Te dicant invenire pro, putant tibique constituam in eam. Vel in adhuc aperiri fierent.</p>"
  end
  html << "</body></html>"
end

def gen_go
  html = make_doc
  k = PDFKit.new(html, page_size: "Letter", print_media_type: true)

  k.to_file("out.pdf")
  system "open out.pdf"
end
