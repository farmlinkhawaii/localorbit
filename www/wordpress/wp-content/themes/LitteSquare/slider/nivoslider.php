<?php
global $theme_options;
$nivo_slider_select_slider = $theme_options["nivo_slider_select_slider"];
wp_enqueue_script('jquery.nivo.slider.pack.js');
?>

<section id="home-top-content">        
	<div class="container">
		<div class="row">
			<!-- Slider -->
	            <section id="nivo-slider" class="span12">
	                <div class="home-nivo-slider">
						<?php
						$sliders = get_post_meta($nivo_slider_select_slider,'_slider_slider');
						
						foreach($sliders[0] as $nivoslider):
							echo '<img src="'.$nivoslider["image"].'" alt="" title="'.$nivoslider["title"].'">';
						endforeach;
						?>
	                </div>
	                <img src="<?php echo THEMESTUDIO_IMG; ?>/nivo-shadow.png" alt="">
	            </section>
				<!-- #nivo-slider -->
			
		</div>
	</div>
</section>
<script type="text/javascript">

	jQuery('.home-nivo-slider').nivoSlider({
		effect: '<?php echo $theme_options['nivo_slider_effect'] ?>', // Specify sets like: 'fold,fade,sliceDown'
		slices: <?php echo $theme_options['nivo_slider_slices']?>, // For slice animations
		boxCols: 8, // For box animations
		boxRows: 4, // For box animations
		animSpeed: <?php echo $theme_options['nivo_slider_speed']?>, // Slide transition speed
		pauseTime: <?php echo $theme_options['nivo_slider_pause_speed']?>, // How long each slide will show
		startSlide: 0, // Set starting Slide (0 index)
		directionNav: <?php if($theme_options['nivo_slider_directionNav']==1) {echo 'true';} else{ echo 'false';}; ?>, // Next & Prev navigation
		controlNav: false, // 1,2,3... navigation
		controlNavThumbs: false, // Use thumbnails for Control Nav
		pauseOnHover: true, // Stop animation while hovering
		manualAdvance: false, // Force manual transitions
		prevText: 'Prev', // Prev directionNav text
		nextText: 'Next', // Next directionNav text
		randomStart: false, // Start on a random slide
	});

</script>