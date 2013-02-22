<?php
class Custom_Html_Display extends WP_Widget{
	  function Custom_Html_Display(){
	  		   $widget_ops=array('classname' => 'Custom_Html_Display', 'description' => 'Display HTML');
			   $this->WP_Widget('Custom_Html_Display', 'Custom Html Display', $widget_ops);
	  }
	  function widget($args, $instance){
	  		   extract($args, EXTR_SKIP);
        		if ( is_active_widget( false, false, $this->id_base, true ) ) {
                	wp_enqueue_script('prettyPhoto');
                }			   
			   echo $before_widget;
			   $title=empty($instance['title']) ? '' : $instance['title'];
			   $content=empty($instance['content']) ? '' : $instance['content'];
			   
			   ?>
			   <h3 class="widget-title"><?php echo $title ; ?></h3>
			   <?php
			   if(!empty($content))
			   {
			   ?>
			   <p><?php echo $content ?></p>
			   <?php
			   }
			   else
			   {
			   echo 'You must add Html content';
			   }
			   echo $after_widget;
	  }
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = $new_instance['content'];

		return $instance;
	}
	function form($instance) {
	$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '') );
		$title = strip_tags($instance['title']);
		$content = $instance['content'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title : <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('content'); ?>">Title : <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="" ><?php echo esc_attr($content); ?></textarea></label></p>
		<?php
	}
}
register_widget('Custom_Html_Display');
?>