<?php
class NHP_Options_fonts extends NHP_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since NHP_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		//$this->render();
		
	}//function
	


	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since NHP_Options 1.0
	*/
	function render(){


		$class = (isset($this->field['class']))?$this->field['class']:'regular-text';
		
		$placeholder = (isset($this->field['placeholder']))?' placeholder="'.esc_attr($this->field['placeholder']).'" ':'';
		
		echo '<input  type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" '.$placeholder.'value="'.esc_attr($this->value).'" class="'.$class.'" />';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';

		echo '<p id="'.$this->field['id'].'demo_font">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>';
		echo "<script>
		      jQuery(function(){
		        jQuery('#".$this->field['id']."').fontselect().change(function(){
		        
		          // replace + signs with spaces for css
		          var font = jQuery(this).val().replace(/\+/g, ' ');
		          
		          // split font into family and weight
		          font = font.split(':');
		          
		          // set family on paragraphs 
		          jQuery('#".$this->field['id']."demo_font').css('font-family', font[0]);
		        });
		      });
		    </script>";
		
	}//function

		function enqueue(){
		wp_enqueue_style( 'select-font-style', NHP_OPTIONS_URL.'fields/fonts/fontselect.css' );
		wp_enqueue_script(
			'ts-options-field-font-js', 
			NHP_OPTIONS_URL.'fields/fonts/jquery.fontselect.min.js', 
			array('jquery'),
			time(),
			true
		);
		
	}//function
	
}//class
?>