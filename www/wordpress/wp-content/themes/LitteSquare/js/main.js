jQuery(function() {

	
/* ----- Main Menu ----- */
	
	if(jQuery().superfish) {
		jQuery("#header nav > ul").superfish({
			delay: 150, // delay on mouseout 
	        animation: { opacity:'show',height:'show' }, // fade-in and slide-down animation 
	        speed: 'fast', // faster animation speed 
	        autoArrows: true, // disable generation of arrow mark-up 
	        dropShadows: false,
		});
	}
	
	if(jQuery().mobileMenu) {
		jQuery('#header-navigation nav').each(function(){
			jQuery(this).mobileMenu();
		});
	}

	if(jQuery().prettyPhoto){
		jQuery("a[rel^='prettyPhoto']").prettyPhoto();
	};

/* ----- Carousels & Sliders ----- */
	
	// default flex parameters
	if(jQuery().flexslider) {
		jQuery('#body .flexslider').flexslider({
			controlNav: false,
			slideshow: false
		});
	}
	
	/* homepage top content flex parameters */
	if(jQuery().flexslider) {
		jQuery('#home-top-content .flexslider').flexslider({
			controlNav: true,
			directionNav: false,
			slideshow: true
		});
	}

	if(jQuery().nivoSlider) {
		jQuery('.nivo-slider').nivoSlider({
			effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
			slices: 15, // For slice animations
			boxCols: 8, // For box animations
			boxRows: 4, // For box animations
			animSpeed: 500, // Slide transition speed
			pauseTime: 6000, // How long each slide will show
			startSlide: 0, // Set starting Slide (0 index)
			directionNav: true, // Next & Prev navigation
			controlNav: false, // 1,2,3... navigation
			controlNavThumbs: false, // Use thumbnails for Control Nav
			pauseOnHover: true, // Stop animation while hovering
			manualAdvance: false, // Force manual transitions
			prevText: 'Prev', // Prev directionNav text
			nextText: 'Next', // Next directionNav text
			randomStart: false, // Start on a random slide
			beforeChange: function(){}, // Triggers before a slide transition
			afterChange: function(){}, // Triggers after a slide transition
			slideshowEnd: function(){}, // Triggers after all slides have been shown
			lastSlide: function(){}, // Triggers when last slide is shown
			afterLoad: function(){} // Triggers when slider has loaded
		});
		
		
	}
	
	// parallax content slider
	if(jQuery().cslider) {
		jQuery('#da-slider').cslider({
			bgincrement	: 0,
			current: 0,
			autoplay: true,
			interval: 6000
		});
	}
	if(jQuery().pretyPhoto) {
		jQuery('a[rel=pretyPhoto]').pretyPhoto();
	}


/* ----- Twitter Feed ----- */
	
	if(jQuery().tweet) {
		jQuery(".widget_twitter div").tweet({
			username: "envato",
			join_text: "auto",
			avatar_size: 0,
			count: 2,
			auto_join_text_default: "",
			auto_join_text_ed: "",
			auto_join_text_ing: "",
			auto_join_text_reply: "",
			auto_join_text_url: "",
			loading_text: "loading tweets..."
	    });
	}
	
	
	
/* ----- Portfolio ----- */	

	jQuery("#filter a").click(function(event){
		event.preventDefault();
		jQuery("#filter a.active").removeClass("active");
		jQuery(this).addClass("active");

		p_filter = jQuery(this).attr("href").substr(1);

		jQuery("#portfolio-container > dl").each(function(){
			p_property = jQuery(this).attr("data-work");
			if(p_property.indexOf(p_filter) >= 0 && p_filter != "all") {
				jQuery(this).fadeTo(300, 1);
			} else if(p_filter != "all") {
				jQuery(this).fadeTo(300, 0.05);
			} else {
				jQuery(this).fadeTo(300, 1);
			}
		});
	});

	jQuery(".tslike").click(function(){
		likeid =  jQuery(this).attr("id");
		id = likeid.substring(5,likeid.lenght);
		var MyAjax = {
		   ajaxurl: "wp-admin/admin-ajax.php"
		};
		jQuery.post(
			MyAjax.ajaxurl,
			{
			action:'ajax_like',
			post_ID :id
			},
            function( response ) {
				if(response != 'You Have Liked!'){
				jQuery("#like-"+id).html(response);
				}else{
				alert('You Have Liked!');
				}
				
			}
			);
	
	});
	/*
	if(jQuery().greyScale) {
		// fade in the grayscaled images to avoid visual jump	
		jQuery('.greyScale').one("load", function(){
			jQuery(this).animate({
				opacity: 1
			}, 1000).greyScale({
				fadeTime: 500,
				reverse: false	
			});
		}).each(function() {
			if(this.complete) jQuery(this).trigger("load");
		});
	}	
	*/
	// On window load. This waits until images have loaded which is essential
	
	jQuery(window).load(function(){
		
		// Fade in images so there isn't a color "pop" document load and then on window load
		jQuery(".greyScale").animate({opacity:1},500);
		
		// clone image
		jQuery('.greyScale').each(function(){
			var el = jQuery(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"998","opacity":"0"}).insertBefore(el).queue(function(){
				var el = jQuery(this);
				el.parent().css({"width":this.width,"height":this.height-5});
				el.dequeue();
			});
			this.src = grayscale(this.src);
		});
		
		// Fade image 
		jQuery('.greyScale').mouseover(function(){
			jQuery(this).parent().find('img:first').stop().animate({opacity:1}, 1000);
		})
		jQuery('.img_grayscale').mouseout(function(){
			jQuery(this).stop().animate({opacity:0}, 1000);
		});		
	});	
	// Grayscale w canvas method
	function grayscale(src){
        var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
        var imgObj = new Image();
		imgObj.src = src;
		canvas.width = imgObj.width;
		canvas.height = imgObj.height; 
		ctx.drawImage(imgObj, 0, 0); 
		var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg; 
				imgPixels.data[i + 1] = avg; 
				imgPixels.data[i + 2] = avg;
			}
		}
		ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
		return canvas.toDataURL();
    }
/* ----- Shortcodes ----- */	
	
    jQuery('.accordion').on('show', function(e) {
         jQuery(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('collapsed');
    });

    jQuery('.accordion').on('hide', function(e) {
        jQuery(this).find('.accordion-toggle').not(jQuery(e.target)).removeClass('collapsed');
    });	
	


/* ----- Forms ----- */	

	if (!Modernizr.input.placeholder){
		jQuery("input").each(function(){
			if(jQuery(this).val()=="" && jQuery(this).attr("placeholder")!=""){
				jQuery(this).val(jQuery(this).attr("placeholder"));
				jQuery(this).focus(function(){
					if(jQuery(this).val()==jQuery(this).attr("placeholder")) jQuery(this).val("");
				});
				jQuery(this).blur(function(){
					if(jQuery(this).val()=="") jQuery(this).val(jQuery(this).attr("placeholder"));
				});
			}
		});
	}

	
});
