jQuery(document).ready(function(){
	
	jQuery('.ts-options-checkbox-hide-belows').each(function(){
		if(!jQuery(this).is(':checked')){
			var id = jQuery(this).attr("id");
			jQuery("."+id).each(function(){
				jQuery(this).closest('tr').hide();
			});
		}
	});
	
	jQuery('.ts-options-checkbox-hide-belows').click(function(){
		
		if(jQuery(this).is(':checked')){
			var id = jQuery(this).attr("id");
			
			jQuery("."+id).each(function(){
				jQuery(this).closest('tr').toggle('slow');
			});
		}else{
			var id = jQuery(this).attr("id");
			
			jQuery("."+id).each(function(){
				jQuery(this).closest('tr').hide();
			});		
		};
	});
	
});