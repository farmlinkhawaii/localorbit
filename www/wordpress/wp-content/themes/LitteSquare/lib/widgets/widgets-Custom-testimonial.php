<?php
class Custom_Testimonial extends WP_Widget {
	function Custom_Testimonial() {
		$widget_ops = array('classname' => 'Custom_Testimonial', 'description' => 'Display customer testimonials' );
		$this->WP_Widget('Custom_Testimonial', 'Custom Testimonial', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = $instance['title'];
		$message = $instance['message'];
		$from = $instance['from'];
		
		if(empty($title))
		{
			$title = 'Testimonial';
		}
		
		echo '<h3 class="widget-title">'.$title.'</h3>';
		echo '<div class="testimonial_wrapper">'.do_shortcode($message).'</div>';
		echo '<div class="testimonial_arrow"></div>';
		echo '<div class="testimonial_name"><strong>'.$from.'</strong></div>';
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['message'] = strip_tags($new_instance['message']);
		$instance['from'] = strip_tags($new_instance['from']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'message' => '', 'title' => '', 'from' => '') );
		$message = strip_tags($instance['message']);
		$title = strip_tags($instance['title']);
		$from = strip_tags($instance['from']);

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('message'); ?>">Message: <textarea class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>"><?php echo esc_attr($message); ?></textarea></label></p>
			
			<p><label for="<?php echo $this->get_field_id('from'); ?>">From: <input class="widefat" id="<?php echo $this->get_field_id('from'); ?>" name="<?php echo $this->get_field_name('from'); ?>" type="text" value="<?php echo esc_attr($from); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Testimonial');
?>