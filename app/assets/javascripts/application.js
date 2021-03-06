// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or vendor/assets/javascripts of plugins, if any, can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// compiled file.
//
// Read Sprockets README (https://github.com/sstephenson/sprockets#sprockets-directives) for details
// about supported directives.
//

//= require es5-shim
//= require es6-shim
//= require jquery
//= require jquery_ujs
//= require jquery-ui
//= require jquery-readyselector
//= require chosen-jquery
//= require typeahead-0.11.1
//= require q
//= require parser_rules/advanced
//= require wysihtml5
//= require underscore
//= require accountingjs
//= require jquery.tablesorter.min
//= require knockout-3.2.0
//= require bootstrap_knockout_modules
//= stub balanced
//= stub stripe

//= require components
//= require reflux.min
//= require froala_editor.min
//= require fSelect
//= require BpTspSolver
//= require tsp.js.erb
//
//= require plugins/block_styles.min.js
//= require plugins/colors.min.js
//= require plugins/entities.min.js
//= require plugins/font_family.min.js
//= require plugins/font_size.min.js
//= require plugins/inline_styles.min.js
//= require plugins/lists.min.js
//= require plugins/media_manager.min.js
//= require plugins/tables.min.js
//= require plugins/urls.min.js
//= require s3_direct_upload
//= require jSignature.min.js

//
//= require_tree .
//= stub sticky-headers
//= stub resolution
//= stub synchronousRemote
//= stub roll_your_own_market

$(function() {
    $('#s3_uploader').S3Uploader({
        remove_completed_progress_bar: false,
        progress_bar_target: $('#uploads_container')
    });

    $('#s3_uploader').bind('s3_upload_failed', function(e, content) {
        return alert(content.filename + ' failed to upload. Error: ' + content.error_thrown);
    });

    $('#s3_uploader').bind('s3_upload_complete', function(e, content) {
        $('#aws_url').val(content.url);
        $('#product_img').html('<img src="'+content.url+'" />');
        $('.upload').hide();
    });
});
