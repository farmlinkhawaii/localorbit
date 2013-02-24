<?php
class NHP_Options_sortable extends NHP_Options{	
	
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


			$sortlists = $this->value;
			$output ='';
			$output .= '<div id="'.$this->field['id'].'" class="sorter">';
			
			
			if ($sortlists) {
			
				foreach ($sortlists as $group=>$sortlist) {

					$output .= '<ul id="'.$this->field['id'].'_'.$group.'" class="sortlist_'.$this->field['id'].'">';
					$output .= '<h3>'.$group.'</h3>';
					
					foreach ($sortlist as $key => $list) {
					
							$output .= '<input class="sorter-placebo" type="hidden" name="'.$this->args['opt_name'].'['.$this->field['id'].']'.'['.$group.'][placebo]" value="placebo">';
							
						if ($key != "placebo") {
						
							$output .= '<li id="'.$key.'" class="sortee">';
							$output .= '<input class="position" type="hidden"       name="'.$this->args['opt_name'].'['.$this->field['id'].']['.$group.']['.$key.']" value="'.$list.'">';
							$output .= $list;
							$output .= '</li>';
							
						}
						
					}
					
					$output .= '</ul>';
				}
			}
			
			$output .= '</div>';

			$output .= "
			<script>
			jQuery(document).ready(function(){
				jQuery('.sorter').each( function() {
					var id = jQuery(this).attr('id');
					jQuery('#'+ id).find('ul').sortable({
						items: 'li',
						placeholder: \"placeholder\",
						connectWith: '.sortlist_' + id,
						opacity: 0.6,
						update: function() {
							jQuery(this).find('.position').each( function() {
							
								var listID = jQuery(this).parent().attr('id');
								var parentID = jQuery(this).parent().parent().attr('id');
								
								parentID = parentID.replace(id + '_', '')
								var optionID = jQuery(this).parent().parent().parent().attr('id');
								jQuery(this).prop(\"name\", '".$this->args['opt_name']."[' + optionID + '][' + parentID + '][' + listID + ']');
								
							});
						}
					});	
				});
			
			});
			</script>
			";

			echo $output;

	}//function

	
}//class
?>