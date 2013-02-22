<?php
class NHP_Options_rangeinput extends NHP_Options{	
	
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
		$minval=5;
		$maxval=50;
		$stdval=10;
		
		if (isset($this->field['min'])) {
			$minval = $this->field['min'];
		}
		if (isset($this->field['max'])) {
			$maxval = $this->field['max'];
		}
		if (isset($this->field['std'])) {
			if(isset($this->value)){
				$stdval = $this->value;
			} else
			{
				$stdval = $this->field['std'];
			}
		}
		
		$class = (isset($this->field['class']))?$this->field['class']:'regular-text';
		
		$placeholder = (isset($this->field['placeholder']))?' placeholder="'.esc_attr($this->field['placeholder']).'" ':'';
		
		echo '<input class="ts_slider" id="'.$this->field['id'].'" type="range" min="0" max="100" step="1" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" '.$placeholder.'value="'.esc_attr($this->value).'" class="'.$class.'" />';
		echo '<div id="'.$this->field['id'].'slider"></div>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
		wp_enqueue_script(
			'jquery-ui-slider'
		);
		echo '<style>.ts_slider{width:80%;}</style><script>
					jQuery(document).ready(function(){
						var input_text = jQuery("#'.$this->field['id'].'slider").parent().children(":first-child");
					  	jQuery( "#'.$this->field['id'].'slider" ).slider({
					            range: "min",
					            value: '.$stdval.',
					            min: '.$minval.',
					            max: '.$maxval.',
					            slide: function( event, ui ) {
					                input_text.val( ui.value+"px" );
					            }
					        });
					        input_text.val( jQuery( "#'.$this->field['id'].'slider" ).slider( "value" )+"px" );
					});
				</script>';
		
	}//function
	
}//class
?>