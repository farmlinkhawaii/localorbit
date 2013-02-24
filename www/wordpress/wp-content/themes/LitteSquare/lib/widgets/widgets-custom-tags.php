<?php
class Custom_Tags extends WP_Widget {
	function Custom_Tags() {
		$widget_ops = array('classname' => 'Custom_Tags', 'description' => 'The Tags list' );
		$this->WP_Widget('Custom_Tags', 'Custom Tags', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? 'Tags' : apply_filters('widget_title', $instance['title']);
		$number = empty($instance['number']) ? 10 : apply_filters('widget_number', $instance['number']);
		 	
			echo '<h3 class = "tags widget-title">'.$title.'</h3>';
			$args = array(
			'number'=>$number,
			);
			$tags = get_tags('');
			echo '<ul class = "tags">';
			foreach($tags as $tag):
			
			echo '<li>
                    <a class="tag" href="'.get_tag_link($tag->term_id).'">
                    '.$tag->name.'
                    </a>
            	  </li>';
			endforeach; 
			echo '</ul>';			  				  
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$instance = wp_parse_args( (array) $instance, array( 'number' => '') );
		$title = strip_tags($instance['title']);
		$title = strip_tags($instance['number']);
		

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title (default "Tags"): <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>">Number (default "10"): <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
			
<?php
	}
}

register_widget('Custom_Tags');
?>