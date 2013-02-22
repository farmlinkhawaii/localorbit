<?php
class Custom_Quick_Contact extends WP_Widget{
	  function Custom_Quick_Contact(){
	  		   $widget_ops=array('classname' => 'Custom_Quick_Contact', 'description' => 'Custom Quick Contact');
			   $this->WP_Widget('Custom_Quick_Contact', 'Custom Quick Contact', $widget_ops);
	  }
	  function widget($args, $instance){
	  		   extract($args, EXTR_SKIP);
			   echo $before_widget;
			   $title=strip_tags($instance['title']);
			   $content=strip_tags($instance['content']);
			   $phone=strip_tags($instance['phone']);
			   $fax=strip_tags($instance['fax']);
			   $mail=strip_tags($instance['mail']);
			   $address=strip_tags($instance['address']);
			   ?>
			   <h3 class="widget-title"><?php echo $title ; ?></h3>
			   <?php
			   if(!empty($content))
			   {
			   ?>
			   <p><?php do_shortcode($content) ?></p>
			   <?php
			   }
			   else
			   {
			   echo 'You must add Html content';
			   }
			   ?>
			   <div class="contact-footer">
                    	<ul>
                            <li><p><span>Phone :</span> <?php echo $phone ;  ?></p></li>
                            <li><p><span>Fax :</span><?php echo $fax ;  ?></p></li>
                            <li><p><span>Email :</span> <a href="mailto:<?php echo $mail ;  ?>"><?php echo $mail ;  ?></a></p></li>
                            <li><p><span>Address :</span> <?php echo $address ;  ?></p></li>
                        </ul>
               </div>
			   <?php
			   echo $after_widget;
	  }
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
        $instance['phone'] =strip_tags( $new_instance['phone']);
        $instance['fax'] = strip_tags($new_instance['fax']);
        $instance['mail'] = strip_tags($new_instance['mail']);
        $instance['address'] = strip_tags($new_instance['address']);
        return $instance;
	}
	function form($instance) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '', 'phone' => '', 'fax' => '', 'mail' => '', 'address' => '') );
        $title=strip_tags($instance['title']);
        $content=strip_tags($instance['content']);
        $phone=strip_tags($instance['phone']);
        $fax=strip_tags($instance['fax']);
        $mail=strip_tags($instance['mail']);
        $address=strip_tags($instance['address']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title : <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('content'); ?>">Content : <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="" ><?php echo esc_attr($content); ?></textarea></label></p>
		<p><label for="<?php echo $this->get_field_id('phone'); ?>">Phone : <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($phone); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('fax'); ?>">Fax : <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo esc_attr($fax); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('mail'); ?>">Mail : <input class="widefat" id="<?php echo $this->get_field_id('mail'); ?>" name="<?php echo $this->get_field_name('mail'); ?>" type="text" value="<?php echo esc_attr($mail); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('address'); ?>">Address : <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo esc_attr($address); ?>" /></label></p>
		<?php
	}
}
register_widget('Custom_Quick_Contact');
?>