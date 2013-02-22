<?php
class Custom_Tabs_Posts extends WP_Widget {
	function Custom_Tabs_Posts() {
		$widget_ops = array('classname' => 'widget_recent_content tabbable', 'description' => 'The recent posts with thumbnails' );
		$this->WP_Widget('Custom_Tabs_Posts', 'Custom Tabs Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
		 				  
			tt_tabsposts($items, TRUE);
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '') );
		$items = strip_tags($instance['items']);
		

?>
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 3): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Tabs_Posts');
class Custom_widget_archives extends WP_Widget {
	function Custom_widget_archives() {
		$widget_ops = array('classname' => 'widget_archives', 'description' => 'The recent posts with thumbnails' );
		$this->WP_Widget('Custom_widget_archives', 'Custom Widget Archives', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$type = empty($instance['type']) ? ' ' : apply_filters('widget_title', $instance['type']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		?>
		<h2 class="section-title"><?php if($title =="" ): echo $title; else: echo "Archives"; endif; ?><span></span><span></span></h2><ul>
		<?php
		if(!empty($items))
		{
			echo wp_get_archives('type=monthly&limit='.$items.'&echo=0');
		}
		?>
		<ul>
		<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['type'] = strip_tags($new_instance['type']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '','type' => '','title' => '') );
		$title = strip_tags($instance['title']);
		$items = strip_tags($instance['items']);
		$type = strip_tags($instance['type']);
		

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title (default Archives): <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Limit (default 4): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('type'); ?>">Type (default yearly): 
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?> value="<?php echo esc_attr($type); ?>">
					<option value="yearly">yearly</option>
					<option value="monthly">monthly</option>
					<option value="daily">daily</option>
					<option value="weekly">weekly</option>
			</select>
			</label>
			</p>
			
<?php
	}
}register_widget('Custom_widget_archives');
?>