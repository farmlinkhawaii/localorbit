<?php
class Custom_Categories extends WP_Widget {
	function Custom_Categories() {
		$widget_ops = array('classname' => 'Custom_Categories', 'description' => 'The categories list' );
		$this->WP_Widget('Custom_Categories', 'Custom categories', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? 'Categories' : apply_filters('widget_title', $instance['title']);
		 	
			echo '<h3 class = "categories widget-title">'.$title.'</h3>';
			$cats = get_categories();
			echo '<ul class = "categories">';
			foreach($cats as $cat):
			
			echo '<li>
                    <a href="'.get_category_link( $cat->term_id ).'">
                    '.$cat->cat_name.'
                    <span>'.ts_get_category_count($cat->cat_ID).'</span>
                    </a>
            	  </li>';
			endforeach; 
			echo '</ul>';			  				  
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
		

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title (default "Category"): <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Categories');
?>