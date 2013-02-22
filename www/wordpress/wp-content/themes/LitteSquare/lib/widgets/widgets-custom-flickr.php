<?php
class Custom_Flickr extends WP_Widget {
	function Custom_Flickr() {
		$widget_ops = array('classname' => 'Custom_Flickr', 'description' => 'Display your recent Flickr photos' );
		$this->WP_Widget('Custom_Flickr', 'Custom Flickr', $widget_ops);
		
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
    	
		
		if ( is_active_widget(false, false, $this->id_base,true) ) {
         	wp_enqueue_script('prettyPhoto');  
      		};	
		echo $before_widget;
		$flickr_id = empty($instance['flickr_id']) ? ' ' : apply_filters('widget_title', $instance['flickr_id']);
		$title = $instance['title'];
		$items = $instance['items'];
		
		if(!is_numeric($items))
		{
			$items = 9;
		}
		
		if(empty($title))
		{
			$title = 'Photostream';
		}
		
		if(!empty($items) && !empty($flickr_id))
		{
			$photos_arr = get_flickr(array('type' => 'user', 'id' => $flickr_id, 'items' => $items));
			
			if(!empty($photos_arr))
			{
				wp_enqueue_script('prettyphoto');
				wp_enqueue_style('prettyphoto');
				echo '<h3 class="widget-title">'.$title.'</h3>';
				
				echo '<ul class="widget-flickr">';
				
				foreach($photos_arr as $photo)
				{
					echo '<li class="flickr_badge_image">';
					echo '<a rel="prettyPhoto" href="'.$photo['url'].'" title="'.$photo['title'].'"><img src="'.$photo['thumb_url'].'" alt="" class="img_nofade" /></a>';
					echo '</li>';
				}
				
				echo '</ul><div class="clearfix"></div>';
			}
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'flickr_id' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$flickr_id = strip_tags($instance['flickr_id']);
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>">Flickr ID <a href="http://idgettr.com/">Find your Flickr ID here</a>: <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 9): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Flickr');
?>