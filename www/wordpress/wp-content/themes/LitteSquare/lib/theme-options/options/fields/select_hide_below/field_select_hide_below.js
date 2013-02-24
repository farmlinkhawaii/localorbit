
/* FOR CHECK  HIDE ELEMENT */
jQuery(document).ready(function(){
	
	jQuery('.selectparent').each(function(){


		// var id = jQuery(this).attr("id");
		// var choice = jQuery(this).val();
		// alert(choice);
		// foreach(jQuery(this).child("options").attr("value")){

		// 	jQuery("#"+id+"_"+jQuery(this).child("options").attr("value")).parent().parent().hide();

		// }

		// if(!jQuery(this).is(':selected')){
		// 	jQuery("#"+id+"_"+choice).parent().parent().toggle('slow');
		// };
		



		var id = jQuery(this).attr("id");
		var choice = jQuery(this).val();
		var i=0;
		jQuery("#"+id).find('option').each(function(){
			
		 	jQuery("#"+id+"_"+jQuery(this).attr('value')).closest('tr').hide();
		 	
		});
		jQuery("#"+id+"_"+choice).closest('tr').toggle('slow');

	});
	
	jQuery('.selectparent').change(function(){

		var id = jQuery(this).attr("id");
		var choice = jQuery(this).val();
		var i=0;
		jQuery("#"+id).find('option').each(function(){
			
		 	jQuery("#"+id+"_"+jQuery(this).attr('value')).closest('tr').hide();
		 	
		});
		jQuery("#"+id+"_"+choice).closest('tr').toggle('slow');
	});
	
});

/* END CHECK HIDE ELEMENT */

