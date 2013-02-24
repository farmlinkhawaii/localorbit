<?php
global $theme_options;
$content = $theme_options['static_slider_textbox'];
$nivo_slider_select_slider = $theme_options["static_slider_select_slider"];
wp_enqueue_script('jquery.flexslider-min.js');
?>
<section id="home-top-content">
    	<div id="static-content">
        
	    	<div class="container">
	        	<div class="row">
	                <div class="span6 pull-right">
	                    <div class="flexslider">
	                        <ul class="slides">
	                        	<?php
								$sliders = get_post_meta($nivo_slider_select_slider,'_slider_slider');
								
								foreach($sliders[0] as $nivoslider):
									echo '<li><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$nivoslider["image"].'&amp;h=232&amp;w=418&amp;zc=1" alt="" title="'.$nivoslider["title"].'"></li>';
									
								endforeach;
								?>
	                        </ul>
						</div>
	                    <img alt="" src="<?php echo THEMESTUDIO_IMG; ?>/flex-shadow.png">
	                </div>
		            <div class="span6 hero-unit">
		                <?php
						echo $content;
						?>
		            </div>
	        	</div>
	       	</div>
            
        </div>
    </section>