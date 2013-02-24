<?php
class Custom_Social extends WP_Widget{
	  function Custom_Social(){
	  		   $widget_ops=array('classname' => 'Custom_Social', 'description' => 'Custom Social');
			   $this->WP_Widget('Custom_Social', 'Custom Social', $widget_ops);
	  }
	  function widget($args, $instance){
	  		   extract($args, EXTR_SKIP);
			   echo $before_widget;
			   $title=$instance['title'] ;
			   $content=$instance['content'];
			   $facebook=$instance['facebook'];
			   $twitter=$instance['twitter'];
			   $linkedin=$instance['linkedin'];
			   $vimeo=$instance['vimeo'];
			   $dribbble=$instance['dribbble'];
			   $delicious=$instance['delicious'];
			   $youtube=$instance['youtube'];
			   $stumbleupon=$instance['stumbleupon'];
			   $flickr=$instance['flickr'];
			   ?>
			   <h3 class="widget-title"><?php echo $title ; ?></h3>
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
			   		<ul class="connect social-links">
					<?php if($facebook != ''): ?>
                        <li class="facebook"><a  title="facebook" href="<?php echo $facebook; ?>">facebook</a></li>
					<?php endif; ?>
                    <?php if($twitter != ''): ?>
                        <li class="twitter"><a  title="twitter" href="<?php echo $twitter; ?>">twitter</a></li>
                    <?php endif; ?>
                    <?php if($linkedin != ''): ?>
                        <li class="linkedin"><a  title="linkedin" href="<?php echo $linkedin; ?>">link</a></li>
                    <?php endif; ?>
                    <?php if($vimeo != ''): ?>
                        <li class="vimeo"><a  title="vimeo" href="<?php echo $vimeo; ?>">vimeo</a></li>
                    <?php endif; ?>
                    <?php if($dribbble != ''): ?>
                        <li class="dribbble"><a  title="dribbble" href="<?php echo $dribbble; ?>">dribbble</a></li>
                    <?php endif; ?>
                    <?php if($delicious != ''): ?>
                        <li class="delicious"><a  title="delicious" href="<?php echo $delicious; ?>">delicious</a></li>
                    <?php endif; ?>
                    <?php if($youtube != ''): ?>
                        <li class="youtube"><a  title="youtube" href="<?php echo $youtube; ?>">youtube</a></li>
                    <?php endif; ?>
                    <?php if($flickr != ''): ?>
                        <li class="flikr"><a  title="flikr" href="<?php echo $flickr; ?>">flikr</a></li>
                    <?php endif; ?>
                    <?php if($stumbleupon != ''): ?>
                        <li class="stumbleupon"><a  title="stumbleupon" href="<?php echo $stumbleupon; ?>">stumbleupon</a></li>
                    <?php endif; ?>
                        
					</ul>
			   <?php
			   echo $after_widget;
	  }
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
        $instance['facebook'] = strip_tags($new_instance['facebook']);
        $instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['linkedin'] = strip_tags($new_instance['linkedin']);
		$instance['vimeo'] = strip_tags($new_instance['vimeo']);
		$instance['dribbble'] = strip_tags($new_instance['dribbble']);
		$instance['delicious'] = strip_tags($new_instance['delicious']);
		$instance['youtube'] = strip_tags($new_instance['youtube']);
		$instance['stumbleupon'] = strip_tags($new_instance['stumbleupon']);
		$instance['flickr'] = strip_tags($new_instance['flickr']);
		return $instance;
	}
	function form($instance) {
	$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '', 'facebook' => '',  'twitter' => '','linkedin'=>'','vimeo'=>'','dribbble'=>'','delicious'=>'','youtube'=>'','stumbleupon'=>'','flickr'=>'') );
    $title=strip_tags($instance['title']);
    $content=strip_tags($instance['content']);
    $facebook=strip_tags($instance['facebook']);
    $twitter = strip_tags($instance['twitter']);
    $linkedin = strip_tags($instance['linkedin']);
    $vimeo = strip_tags($instance['vimeo']);
    $dribbble = strip_tags($instance['dribbble']);
    $delicious = strip_tags($instance['delicious']);
    $youtube = strip_tags($instance['youtube']);
    $stumbleupon = strip_tags($instance['stumbleupon']);
    $flickr = strip_tags($instance['flickr']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title : <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('content'); ?>">Content : <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="" ><?php echo esc_attr($content); ?></textarea></label></p>
		<p><label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook : <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter : <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('linkedin'); ?>">linkedin : <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('vimeo'); ?>">vimeo : <input class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" type="text" value="<?php echo esc_attr($vimeo); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('dribbble'); ?>">dribbble : <input class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" type="text" value="<?php echo esc_attr($dribbble); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('delicious'); ?>">delicious : <input class="widefat" id="<?php echo $this->get_field_id('delicious'); ?>" name="<?php echo $this->get_field_name('delicious'); ?>" type="text" value="<?php echo esc_attr($delicious); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('youtube'); ?>">youtube : <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('stumbleupon'); ?>">stumbleupon : <input class="widefat" id="<?php echo $this->get_field_id('stumbleupon'); ?>" name="<?php echo $this->get_field_name('stumbleupon'); ?>" type="text" value="<?php echo esc_attr($stumbleupon); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('flickr'); ?>">flickr : <input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo esc_attr($flickr); ?>" /></label></p>
		<?php
	}
}
register_widget('Custom_Social');
?>