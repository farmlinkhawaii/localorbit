jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.ts-options-group-tab:first').slideDown('fast');
		jQuery('#ts-options-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+nhp_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(nhp_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.ts-options-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.ts-options-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).delay(100).fadeIn(500);
			}else{
				jQuery(this).fadeOut('fast');
			}
			
		});
		
		jQuery('.ts-options-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#ts-options-save').is(':visible')){
		jQuery('#ts-options-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#ts-options-imported').is(':visible')){
		jQuery('#ts-options-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#ts-options-save-warn').slideDown('slow');
	});
	
	
	jQuery('#ts-options-import-code-button').click(function(){
		if(jQuery('#ts-options-import-link-wrapper').is(':visible')){
			jQuery('#ts-options-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#ts-options-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#ts-options-import-link-button').click(function(){
		if(jQuery('#ts-options-import-code-wrapper').is(':visible')){
			jQuery('#ts-options-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#ts-options-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	
	jQuery('#ts-options-export-code-copy').click(function(){
		if(jQuery('#ts-options-export-link-value').is(':visible')){jQuery('#ts-options-export-link-value').fadeOut('slow');}
		jQuery('#ts-options-export-code').toggle('fade');
	});
	
	jQuery('#ts-options-export-link').click(function(){
		if(jQuery('#ts-options-export-code').is(':visible')){jQuery('#ts-options-export-code').fadeOut('slow');}
		jQuery('#ts-options-export-link-value').toggle('fade');
	});
	
	
	
	/*
	jQuery(function(){
        jQuery("input, textarea, select, button").uniform();
    });
	*/
	
});