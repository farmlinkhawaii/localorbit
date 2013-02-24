jQuery(document).ready(function ($) {	
	
	/**
	 * Metabox of Header Element
	 */
	$('select#_general_header').each(function(){
		var general_option = $(this).children('option:selected').val();
		if (general_option == '') {
			$('#tr_general_subtitle').show();
			$('#tr_general_precontent').hide();
		} else if (general_option == 'pre-content') {
			$('#tr_general_subtitle').hide();
			$('#tr_general_precontent').show();
		} else {
			$('#tr_general_subtitle').hide();
			$('#tr_general_precontent').hide();
		}
	});
	
	$('select#_general_header').change(function(){
		var general_option = $(this).children('option:selected').val();
		if (general_option == '') {
			$('#tr_general_subtitle').fadeIn('slow');
			$('#tr_general_precontent').hide();
		} else if (general_option == 'pre-content') {
			$('#tr_general_subtitle').hide();
			$('#tr_general_precontent').fadeIn('slow');
		} else {
			$('#tr_general_subtitle').hide();
			$('#tr_general_precontent').hide();
		}
	});
	/**
	 * End Header Element
	 */
	/**
	* Metabox for slider
	*/
	/**
	* End Metabox for slider
	*/
	$('select#_slider_slider_type').each(function(){
		var page_option = $(this).children('option:selected').val();
		if (page_option == 'nivo') {
			$('#slide_nivo_metabox').show();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			
			}
		else if (page_option == 'flex') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').show();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'zaccordion') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').show();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'skitter') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').show();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == '3d') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').show();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'roundabout') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').show();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'cycle') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').show();
			}
			
			
		
		});
	$('select#_slider_slider_type').change(function(){
		var page_option = $(this).children('option:selected').val();
		if (page_option == 'nivo') {
			$('#slide_nivo_metabox').show();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			
			}
		else if (page_option == 'flex') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').show();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'zaccordion') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').show();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'skitter') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').show();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == '3d') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').show();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'roundabout') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').show();
			$('#slide_cycle_metabox').hide();
			}
		else if (page_option == 'cycle') {
			$('#slide_nivo_metabox').hide();
			$('#slide_flex_metabox').hide();
			$('#slide_zaccordion_metabox').hide();
			$('#slide_skitter_metabox').hide();
			$('#slide_3d_metabox').hide();
			$('#slide_roundabout_metabox').hide();
			$('#slide_cycle_metabox').show();
			}
		
		});
		
	/**
	 * Metabox of Page
	 */
	 $('select#_page_portfolio').each(function(){
			$('#tr_page_portfolio_Style_1_cols').hide();
			$('#tr_page_portfolio_Style_2_cols').hide();
			$('#tr_page_portfolio_Style_3_cols').hide();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			
			
			var page_option = $(this).children('option:selected').val();
			if(page_option == 'portfolio_Style_1'){
			$('#tr_page_portfolio_Style_1_cols').show();
			$('#tr_page_portfolio_Style_2_cols').hide();
			$('#tr_page_portfolio_Style_3_cols').hide();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			}
			else if(page_option == 'portfolio_Style_2'){
			$('#tr_page_portfolio_Style_1_cols').hide();
			$('#tr_page_portfolio_Style_2_cols').show();
			$('#tr_page_portfolio_Style_3_cols').hide();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			}
			else if(page_option == 'portfolio_Style_3'){
			$('#tr_page_portfolio_Style_1_cols').hide();
			$('#tr_page_portfolio_Style_2_cols').hide();
			$('#tr_page_portfolio_Style_3_cols').show();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			};
			
			
	});
	$('select#_page_portfolio').change(function(){
			
			$('#tr_page_portfolio_Style_1_cols').hide();
			$('#tr_page_portfolio_Style_2_cols').hide();
			$('#tr_page_portfolio_Style_3_cols').hide();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();	
			
			
			var page_option = $(this).children('option:selected').val();
			if(page_option == 'portfolio_Style_1' ){
			$('#tr_page_portfolio_Style_1_cols').show();
			$('#tr_page_portfolio_Style_2_cols').hide();
			$('#tr_page_portfolio_Style_3_cols').hide();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			}
			else if(page_option == 'portfolio_Style_2'){
			$('#tr_page_portfolio_Style_1_cols').hide();
			$('#tr_page_portfolio_Style_2_cols').show();
			$('#tr_page_portfolio_Style_3_cols').hide();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			}
			else if(page_option == 'portfolio_Style_3'){
			$('#tr_page_portfolio_Style_1_cols').hide();
			$('#tr_page_portfolio_Style_2_cols').hide();
			$('#tr_page_portfolio_Style_3_cols').show();
			$('#tr_page_portfolio_overlay_cols').hide();
			$('#tr_page_portfolio_masonry_option').hide();
			$('#tr_page_portfolio_gallery_option').hide();
			};
			
			
	});
	
	$('select#_page_template').each(function(){
			var page_option = $(this).children('option:selected').val();
					if (page_option == 'default') {
						$('#tr_page_default').fadeIn('slow');
						$('#tr_page_default_slider').fadeIn('slow');
						$('#tr_page_blog').hide();
						$('#tr_page_portfolio').hide();
						$('#tr_page__blog_style').hide();
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
						//$('#tr_page_sidebar').fadeIn('slow');
						var default_option = $('select#_page_default').children('option:selected').val();
						if (default_option != 'fw') {
							$('#tr_page_sidebar').fadeIn('slow');
						} else {
							$('#tr_page_sidebar').hide();
						}
						$('#page_blog_metabox').hide();
						$('#page_portfolio_metabox').hide();
									$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
					} else if (page_option == 'blog') {
						$('#tr_page_default').hide();
						$('#tr_page_default_slider').hide();
						$('#tr_page_blog').fadeIn('slow');
						$('#tr_page_portfolio').hide();
						$('#tr_page_sidebar').fadeIn('slow');
						$('#page_blog_metabox').fadeIn('slow');
						$('#page_portfolio_metabox').hide();
									$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page__blog_style').fadeIn('slow');
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
					} else if (page_option == 'portfolio') {
						$('#tr_page_default').hide();
						$('#tr_page_default_slider').hide();
						$('#tr_page_blog').hide();
						$('#tr_page_portfolio').fadeIn('slow');
						$('#tr_page_sidebar').hide();
						$('#page_blog_metabox').hide();
						$('#page_portfolio_metabox').fadeIn('slow');
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page__blog_style').hide();
						$('#tr_page_portfolio_num').show();
						$('#trportfolio_filter').show();
						$('#trpages_portfolio_Category').show();
						
						
						
						
						var portfolio_style = $('select#_page_portfolio').children('option:selected').val();
						if(portfolio_style == 'portfolio_Style_1' ){
						$('#tr_page_portfolio_Style_1_cols').show();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						}
						else if(portfolio_style == 'portfolio_Style_2'){
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').show();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						}
						else if(portfolio_style == 'portfolio_Style_3'){
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').show();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						};
						
						
						
					} else {
						$('#tr_page__blog_style').hide();
						$('#tr_page_default_slider').hide();
						$('#tr_page_default').hide();
						$('#tr_page_blog').hide();
						$('#tr_page_portfolio').hide();
						$('#tr_page_sidebar').hide();
						$('#page_blog_metabox').hide();
						$('#page_portfolio_metabox').hide();
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
					}
	});	
			
	$('select#_page_template').change(function(){
			var page_option = $(this).children('option:selected').val();
					if (page_option == 'default') {
						$('#tr_page__blog_style').hide();
						$('#tr_page_default').fadeIn('slow');
						$('#tr_page_default_slider').fadeIn('slow');
						$('#tr_page_blog').hide();
						$('#tr_page_portfolio').hide();
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
						//$('#tr_page_sidebar').fadeIn('slow');
						var default_option = $('select#_page_default').children('option:selected').val();
						if (default_option != 'fw') {
							$('#tr_page_sidebar').fadeIn('slow');
						} else {
							$('#tr_page_sidebar').hide();
						}
						$('#page_blog_metabox').hide();
						$('#page_portfolio_metabox').hide();
									$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
					} else if (page_option == 'blog') {
						$('#tr_page_default').hide();
						$('#tr_page_default_slider').hide();
						$('#tr_page_blog').fadeIn('slow');
						$('#tr_page__blog_style').fadeIn('slow');
						$('#tr_page_portfolio').hide();
						$('#tr_page_sidebar').fadeIn('slow');
						$('#page_blog_metabox').fadeIn('slow');
						$('#page_portfolio_metabox').hide();
									$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
					} else if (page_option == 'portfolio') {
						$('#tr_page__blog_style').hide();
						$('#tr_page_default').hide();
						$('#tr_page_default_slider').hide();
						$('#tr_page_blog').hide();
						$('#tr_page_portfolio').fadeIn('slow');
						$('#tr_page_sidebar').hide();
						$('#page_blog_metabox').hide();
						$('#page_portfolio_metabox').fadeIn('slow');
						$('#tr_page_portfolio_gallery_option').hide();
						
						$('#tr_page_portfolio_num').show();
						$('#trportfolio_filter').show();
						$('#trpages_portfolio_Category').show();
						
						
						
						
						var portfolio_style = $('select#_page_portfolio').children('option:selected').val();
						if(portfolio_style == 'portfolio_Style_1' ){
						$('#tr_page_portfolio_Style_1_cols').show();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						}
						else if(portfolio_style == 'portfolio_Style_2'){
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').show();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						}
						else if(portfolio_style == 'portfolio_Style_3'){
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').show();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						};
						
						
						
					} else {
						$('#tr_page__blog_style').hide();
						$('#tr_page_default_slider').hide();
						$('#tr_page_default').hide();
						$('#tr_page_blog').hide();
						$('#tr_page_portfolio').hide();
						$('#tr_page_sidebar').hide();
						$('#page_blog_metabox').hide();
						$('#page_portfolio_metabox').hide();
						$('#tr_page_portfolio_Style_1_cols').hide();
						$('#tr_page_portfolio_Style_2_cols').hide();
						$('#tr_page_portfolio_Style_3_cols').hide();
						$('#tr_page_portfolio_masonry_option').hide();
						$('#tr_page_portfolio_overlay_cols').hide();
						$('#tr_page_portfolio_gallery_option').hide();
						$('#tr_page_portfolio_num').hide();
						$('#trportfolio_filter').hide();
						$('#trpages_portfolio_Category').hide();
						
					}
	});	
	
	/*$('select#_page_default').each(function(){
		var default_option = $(this).children('option:selected').val();
		if (default_option != 'fw') {
			$('#tr_page_sidebar').show();
		} else {
			$('#tr_page_sidebar').hide();
		}
	});*/
	
	$('select#_page_default').change(function(){
		var default_option = $(this).children('option:selected').val();
		if (default_option != 'fw') {
			$('#tr_page_sidebar').fadeIn('slow');
		} else {
			$('#tr_page_sidebar').hide();
		}
	});
	/**
	 * End Page
	 */
	/**
	 * Metabox of Blog
	 */
	$('select#_blog_type').each(function(){
		var blog_option = $(this).children('option:selected').val();
		if (blog_option == 'image') {
			$('#tr_blog_image').show();
			$('#tr_blog_video').hide();
			$('#tr_blog_video_thumb').hide();
			$('#tr_blog_slider').hide();
			$('#tr_blog_gallery').hide();

		} else if (blog_option == 'video') {
			$('#tr_blog_image').hide();
			$('#tr_blog_video').show();
			$('#tr_blog_video_thumb').show();
			$('#tr_blog_slider').hide();
			$('#tr_blog_gallery').hide();
		} else if (blog_option == 'slider') {
			$('#tr_blog_image').hide();
			$('#tr_blog_video').hide();
			$('#tr_blog_video_thumb').hide();
			$('#tr_blog_slider').show();
			$('#tr_blog_gallery').hide();
		}
		
		else if (blog_option == 'gallery') {
			$('#tr_blog_image').hide();
			$('#tr_blog_video').hide();
			$('#tr_blog_video_thumb').hide();
			$('#tr_blog_slider').hide();
			$('#tr_blog_gallery').show();
		}

	});
	
	$('select#_blog_type').change(function(){
		var blog_option = $(this).children('option:selected').val();
		if (blog_option == 'image') {
			$('#tr_blog_image').fadeIn('slow');
			$('#tr_blog_video').hide();
			$('#tr_blog_video_thumb').hide();
			$('#tr_blog_slider').hide();
			$('#tr_blog_gallery').hide();
		} else if (blog_option == 'video') {
			$('#tr_blog_image').hide();
			$('#tr_blog_video').fadeIn('slow');
			$('#tr_blog_video_thumb').fadeIn('slow');
			$('#tr_blog_slider').hide();
			$('#tr_blog_gallery').hide();
		} else if (blog_option == 'slider') {
			$('#tr_blog_image').hide();
			$('#tr_blog_video').hide();
			$('#tr_blog_video_thumb').hide();
			$('#tr_blog_slider').fadeIn('slow');
			$('#tr_blog_gallery').hide();
		}
		else if (blog_option == 'gallery') {
			$('#tr_blog_image').hide();
			$('#tr_blog_video').hide();
			$('#tr_blog_video_thumb').hide();
			$('#tr_blog_gallery').fadeIn('slow');
			$('#tr_blog_slider').hide();
		};

	});
	/**
	 * End Blog
	 */


	/**
	 * Metabox of Portfolio
	 */
	$('select#_portfolio_type').each(function(){
		var portfolio_option = $(this).children('option:selected').val();
		if (portfolio_option == 'image') {
			$('#tr_portfolio_image').show();
			$('#tr_portfolio_video').hide();
			$('#tr_portfolio_video_thumb').hide();
			$('#tr_portfolio_slider').hide();
		} else if (portfolio_option == 'video') {
			$('#tr_portfolio_image').hide();
			$('#tr_portfolio_video').show();
			$('#tr_portfolio_video_thumb').show();
			$('#tr_portfolio_slider').hide();
		} else if (portfolio_option == 'slider') {
			$('#tr_portfolio_image').hide();
			$('#tr_portfolio_video').hide();
			$('#tr_portfolio_video_thumb').hide();
			$('#tr_portfolio_slider').show();
		}
	});
	
	$('select#_portfolio_type').change(function(){
		var portfolio_option = $(this).children('option:selected').val();
		if (portfolio_option == 'image') {
			$('#tr_portfolio_image').fadeIn('slow');
			$('#tr_portfolio_video').hide();
			$('#tr_portfolio_video_thumb').hide();
			$('#tr_portfolio_slider').hide();
		} else if (portfolio_option == 'video') {
			$('#tr_portfolio_image').hide();
			$('#tr_portfolio_video').fadeIn('slow');
			$('#tr_portfolio_video_thumb').fadeIn('slow');
			$('#tr_portfolio_slider').hide();
		} else if (portfolio_option == 'slider') {
			$('#tr_portfolio_image').hide();
			$('#tr_portfolio_video').hide();
			$('#tr_portfolio_video_thumb').hide();
			$('#tr_portfolio_slider').fadeIn('slow');
		}
	});
	/**
	 * End Portfolio
	 */
	
	/**
	 * Metabox of Slideshow
	 */
	$('select#_slides_type').each(function(){
		var slides_option = $(this).children('option:selected').val();
		if (slides_option == 'image') {
			$('#tr_slides_image').show();
			$('#tr_slides_video').hide();
		} else if (slides_option == 'video') {
			$('#tr_slides_image').hide();
			$('#tr_slides_video').show();
		}
	});
	
	$('select#_slides_type').change(function(){
		var slides_option = $(this).children('option:selected').val();
		if (slides_option == 'image') {
			$('#tr_slides_image').fadeIn('slow');
			$('#tr_slides_video').hide();
		} else if (slides_option == 'video') {
			$('#tr_slides_image').hide();
			$('#tr_slides_video').fadeIn('slow');
		}
	});
	/**
	 * End Portfolio
	 */
	 

});