<?php
class Custom_Contact_Form extends WP_Widget {
	function Custom_Contact_Form() {
		$widget_ops = array('classname' => 'Custom_Contact_Form', 'description' => 'Display contact form' );
		$this->WP_Widget('Custom_Contact_Form', 'Custom Contact Form', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		if(empty($title))
		{
			$title = 'Contact Us';
		}
		wp_enqueue_script("validate");
		$pp_contact_email = get_option('pp_contact_email');
		
		echo '<h3 class="widget-title">'.$title.'</h3>';
?>

			<form id="wg_contact_form" method="post" action="<?php echo API_URI; ?>/api_send_email.php">
				<input type="hidden" id="contact_email" name="contact_email" value="<?php echo get_theme_option('contact','email'); ?>"/>
				<p>
				    <input id="wg_your_name" name="name" placeholder="Name ..." title="Name" type="text" style="width:90%"/>
				</p>
				<p>
				    <input id="wg_email" name="email" placeholder="Email ..." type="text" title="Email" style="width:90%"/>
				</p>
				<p>
				    <textarea id="wg_message" name="message" placeholder="Message ..." title="Message" rows="2" cols="10" style="width:90%;height:60px"></textarea>
				</p>
				<p>
				    <input type="submit" class="submit button" value="Send Message"/><br/>
				</p>
			</form>
			<div id="reponse_msg"></div>
<?php
echo'<script type="text/javascript">
	jQuery(document).ready(function(){ 
		jQuery("#wg_contact_form").validate({
			meta: "validate",
			submitHandler: function (form) {
				var s_name=jQuery("#wg_your_name").val();
				var s_email=jQuery("#wg_email").val();
				var s_comment=jQuery("#wg_message").val();';
echo '
	  			data={
					 action : \'wgcontact\',
					 name: s_name,
					 email: s_email,
					 message: s_comment';		 
echo'				};';				
echo '
				var ajax_url = "wp-admin/admin-ajax.php";
				
				jQuery.post(ajax_url,data,
				function(result){
                  alert(result);
                });
				return false;
				},
				
				
			/* */
			rules: {
				name: "required",

				email: { // compound rule
					required: true,
					email: true
				},
				message: {
					required: true
				}
			},
			messages: {
				name: "*",
				email: {
					required: "*",
					email: "*"
				},
				message: "*"
			},
		});
	});		
</script>';	
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '','title'=>'') );
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Contact_Form');
?>