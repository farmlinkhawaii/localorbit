
/* FOR CHECK  HIDE ELEMENT */
jQuery(document).ready(function(){
	jQuery('.selectparents').each(function(){	
		var id = jQuery(this).attr("id");
		var choice = jQuery(this).val();
		var i=0;
		jQuery("#"+id).find('option').each(function(){
		 	jQuery("."+id+"_"+jQuery(this).attr('value')).each(function(){
				jQuery(this).closest('tr').hide();
			});
		});
		jQuery("."+id+"_"+choice).each(function(){
				jQuery(this).closest('tr').toggle('slow');
			});
	});
	
	jQuery('.selectparents').change(function(){
		
		var id = jQuery(this).attr("id");
		var choice = jQuery(this).val();
		var i=0;
		jQuery("#"+id).find('option').each(function(){
		 	jQuery("."+id+"_"+jQuery(this).attr('value')).each(function(){
				jQuery(this).closest('tr').hide();
			});
		});
		jQuery("."+id+"_"+choice).each(function(){
				jQuery(this).closest('tr').toggle('slow');
			});
	});
	
});
