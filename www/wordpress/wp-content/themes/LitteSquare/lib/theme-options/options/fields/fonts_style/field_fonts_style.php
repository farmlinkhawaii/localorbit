<?php

class NHP_Options_fonts_style extends NHP_Options{	
	
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
		echo '<div class="farb-popup-wrapper">';
		$class = (isset($this->field['class']))?'class="'.$this->field['class'].'" ':'';
		echo '<div id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']"  >';

			foreach($this->field['options'] as $type=>$font_style){

				if ($type=='font_color') {
					echo '<input type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$type.']" value="'.$this->value[$type].'" class="'.$class.' popup-colorpicker" style="width:70px;"/>';
					echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'picker" class="color-picker"></div></div></div>';
				}else{
				echo '<select id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$type.']" '.$class.'rows="6" >';
				foreach ($font_style as $k => $v) {
					echo '<option value="'.$k.'" '.selected($this->value[$type], $k, false).'>'.$v.'</option>';
				}
				echo '</select>';
				}
				
			}//foreach

		echo '</div>';
		echo '</div>';

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
		
	}//function
	
	function enqueue(){
		
		wp_enqueue_script(
			'ts-options-field-color-js', 
			NHP_OPTIONS_URL.'fields/color/field_color.js', 
			array('jquery', 'farbtastic'),
			time(),
			true
		);
		
	}//function

}//class
?>