jQuery(document).ready(function(){
	var input_text = jQuery("#ts_slider").parent().children(":first-child");
  	jQuery( "#ts_slider" ).slider({
            range: "min",
            value: 37,
            min: 1,
            max: 700,
            slide: function( event, ui ) {
                input_text.val( ui.value );
            }
        });
        input_text.val( + jQuery( "#ts_slider" ).slider( "value" ) );
});