<?php
class Custom_Map extends WP_Widget {
	function Custom_Map() {
		$widget_ops = array('classname' => 'Custom_Map', 'description' => 'Display map' );
		$this->WP_Widget('Custom_Map', 'Custom Map', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? 'Map' : $instance['title'];
		$width = empty($instance['width']) ? 180 : $instance['width'];
		$height = empty($instance['height']) ? 240 : $instance['height'];
		$lat = empty($instance['lat']) ? 0 : $instance['lat'];
		$long = empty($instance['long']) ? 0 : $instance['long'];
		
		$custom_id = time().rand();
       if ( is_active_widget(false, false, $this->id_base,true) ) {
      		wp_enqueue_script('google_map');
              wp_enqueue_script('gmap');
            };	
		echo '<h3 class="widget-title">'.$title.'</h3>';
		
		$marker = '';
		if(!empty($lat) && !empty($long))
		{
			$marker = '{ zoom: 12, markers: [ { latitude: '.$lat.', longitude: '.$long.' } ] }';
		}
		  
?>

			<div id="map<?php echo $custom_id; ?>" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;margin-bottom:15px;margin-top:25px;"></div>
			<script>
				jQuery(document).ready(function(){ 
					jQuery("#map<?php echo $custom_id; ?>").gMap(<?php echo $marker; ?>);
				});
			</script>
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['lat'] = strip_tags($new_instance['lat']);
		$instance['long'] = strip_tags($new_instance['long']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'title' => '', 'width' => '', 'height' => '', 'lat' => '', 'long' => '') );
		$title = strip_tags($instance['title']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$lat = strip_tags($instance['lat']);
		$long = strip_tags($instance['long']);

?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('width'); ?>">Width: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('height'); ?>">Height: <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('lat'); ?>">Latitude (<a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>): <input class="widefat" id="<?php echo $this->get_field_id('lat'); ?>" name="<?php echo $this->get_field_name('lat'); ?>" type="text" value="<?php echo esc_attr($lat); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('long'); ?>">Longitude (<a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>): <input class="widefat" id="<?php echo $this->get_field_id('long'); ?>" name="<?php echo $this->get_field_name('long'); ?>" type="text" value="<?php echo esc_attr($long); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Map');
?>