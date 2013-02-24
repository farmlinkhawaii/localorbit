<?php
global $theme_options;
//$content = $theme_options['static_slider_textbox'];
//$nivo_slider_select_slider = $theme_options["static_slider_select_slider"];
?>
<script type="text/javascript">
jQuery(".sequence_wrap").hover(function(){
jQuery(".sequence_wrap .controls").css("display","block");
},function(){
jQuery(".sequence_wrap .controls").css("display","none");
})
</script>
<section id="home-top-content">
    	<section id="slider-parallax">
			<?php
			global $theme_options;
			if(isset($theme_options["layer_slider_select_slider"]))
			echo do_shortcode("[layerslider id=".$theme_options["layer_slider_select_slider"]."]"); ?>
        </div>
    </section>
</section>	