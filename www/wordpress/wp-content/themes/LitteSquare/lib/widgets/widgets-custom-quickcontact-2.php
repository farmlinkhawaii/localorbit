<?php
class Custom_Quick_Contact_2 extends WP_Widget{
	  function Custom_Quick_Contact_2(){
	  		   $widget_ops=array('classname' => 'Custom_Quick_Contact_2', 'description' => 'Custom Quick Contact 2');
			   $this->WP_Widget('Custom_Quick_Contact_2', 'Custom Quick Contact 2', $widget_ops);
	  }
	  function widget($args, $instance){
	  		   extract($args, EXTR_SKIP);
			   echo $before_widget;
			   $title=strip_tags($instance['title']);
			   $content=strip_tags($instance['content']);
			   $phone=strip_tags($instance['phone']);
			   $fax=strip_tags($instance['fax']);
			   $mail=strip_tags($instance['mail']);
			   $website=strip_tags($instance['website']);
			   
			   ?>
			   <h3 class="contact_information widget-title"><?php echo $title ; ?></h3>
			   <div class="contactInfo-wrap">
			   <?php
			   if(!empty($content))
			   {
			   ?>
			   
			   <p><?php echo do_shortcode($content) ?></p>
			   <?php
			   }
			   else
			   {
			   echo 'You must add Html content';
			   }
			   ?>
                    	<ul class="contactInfo-list">
                            <li class="location"><span>L:</span><?php echo $website ;  ?></li>
                            <li class="phone"><span>P:</span><?php echo $phone ;  ?></li>
                            <li class="fax"><span>F:</span><?php echo $fax ;  ?></li>
                            <li class="mailing"><span>M:</span><a href="mailto:<?php echo $mail; ?>"><?php echo $mail ;  ?></a></li>

						</ul>
						<div class="clearfix"></div>
			  </div> <?php
			   echo $after_widget;
	  }
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
        $instance['phone'] =strip_tags( $new_instance['phone']);
        $instance['fax'] = strip_tags($new_instance['fax']);
        $instance['mail'] = strip_tags($new_instance['mail']);
        $instance['website'] = strip_tags($new_instance['website']);
		return $instance;
	}
	function form($instance) {
    	$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '', 'phone' => '', 'fax' => '', 'mail' => '', 'website' => '') );
        $title=empty($instance['title']) ? '' : $instance['title'];
        $content=empty($instance['content']) ? '' : $instance['content'];
        $phone=empty($instance['phone']) ? '' : $instance['phone'];
        $fax=empty($instance['fax']) ? '' : $instance['fax'];
        $mail=empty($instance['mail']) ? '' : $instance['mail'];
        $website=empty($instance['website']) ? '' : $instance['website'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title : <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('content'); ?>">Content : <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="" ><?php echo esc_attr($content); ?></textarea></label></p>
		<p><label for="<?php echo $this->get_field_id('phone'); ?>">Phone : <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($phone); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('fax'); ?>">Fax : <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo esc_attr($fax); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('mail'); ?>">Mail : <input class="widefat" id="<?php echo $this->get_field_id('mail'); ?>" name="<?php echo $this->get_field_name('mail'); ?>" type="text" value="<?php echo esc_attr($mail); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('website'); ?>">Website : <input class="widefat" id="<?php echo $this->get_field_id('website'); ?>" name="<?php echo $this->get_field_name('website'); ?>" type="text" value="<?php echo esc_attr($website); ?>" /></label></p>
		<?php
	}
}
register_widget('Custom_Quick_Contact_2');
?>