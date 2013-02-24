<?php
/**
 * An example of how to write WPBakery Visual Composer custom shortcode
 *
 * To create shortcodes for visual composer you need to complete 2 steps.
 *
 * 1. Create new class which extends WPBakeryShortCode.
 * If you are not familiar with OOP in php, don't worry follow this instruction and we will guide you how to
 * create valid shortcode for visual composer without learning OOP.
 *
 * 2. Need to create configurations by using wpb_map function.
 *
 * Shortcode class.
 * Shortcode class extends WPBakeryShortCode abstract class.
 * Correct name for shortcode class should look like WPBakeryShortCode_YOUR_SHORTCODE_HERE.
 * YOUR_SHORTCODE_HERE must contain only latin letters, numbers and symbol "_".
*/

/**
 * Shortcode class example "Hello World"
 *
 * Lets pretend that we want to create shortcode with this structure: [my_hello_world foo="bar"]Shortcode content here[/my_hello_world]
 */

class WPBakeryShortCode_ts_services_style_2 extends WPBakeryShortCode {

    /*
     * Thi methods returns HTML code for frontend representation of your shortcode.
     * You can use your own html markup.
     *
     * @param $atts - shortcode attributes
     * @param @content - shortcode content
     *
     * @access protected
     *
     * @return string
     */

    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
            'width' => '1/2',
            'el_position' => '',
            'title' => '',
			'image_position' => '',
			'text_align' => '',
			'ts_icon_type' => '',
			'ts_image_icon' => '',
			'ts_custom_image' => '',
			'ts_content' => '',
        ), $atts));
		
		$width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output1 = 	'
						<div class="services-style2 text-'.$text_align.'">
							';
		if($ts_icon_type == 'number'):					
		
		elseif($ts_icon_type == 'image'):		
		$output1 .=			'<div class="pull-'.$image_position.'"><img alt="" src="'.THEMESTUDIO_IMG.'/pictures/icons/big/'.$ts_image_icon.'.png"></div>';	
		elseif($ts_icon_type == 'custom_image'):	
		$output1 .=			'<div class="pull-'.$image_position.'"><img alt="" src="'.wp_get_attachment_url($ts_custom_image).'"></div>';
		endif;
		$output1 .=			'
							<h3>'.$title.'</h3>
							'.wpb_js_remove_wpautop($content).'
						</div>
		';
        $output  = '<div class="' . $width_class . '">';
	        
	        $output .= $output1;
	        
        $output .= '</div>';
        
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}
/*
Services Style 1 Map
*/
$icons_services_arr = array(
	__("i-big-11","TS") => "i-big-11",
	__("i-big-21","TS") => "i-big-21",
	__("i-big-31","TS") => "i-big-31",
	__("i-big-41","TS") => "i-big-41",
);
wpb_map( array(
	"name"		=> __("Services style 2","TS"),
	"base"		=> "ts_services_style_2",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Content',"TS"),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Title","TS"),
			"param_name" => "title",
			"value" => "",
			"description" => __("Enter your title.","TS")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image Position","TS"),
			"param_name" => "image_position",
			"value" =>  array(__("center","TS") => "center", __("left","TS") => "left", __("right","TS") => "right"),
			"description" => __("Choice A Position for Image.","TS")
		),		
		array(
			"type" => "dropdown",
			"heading" => __("Choice align for text","TS"),
			"param_name" => "text_align",
			"value" =>  array(__("center","TS") => "center", __("left","TS") => "left", __("right","TS") => "right"),
			"description" => __("Choice align type for text.","TS")
		),		
		
		array(
			"type" => "dropdown",
			"heading" => __("Icon","TS"),
			"param_name" => "ts_icon_type",
			"value" =>  array(__("Image","TS") => "image", __("Your Image","TS") => "custom_image"),
			"description" => __("Select Icon Type.","TS")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image Icon","TS"),
			"param_name" => "ts_image_icon",
			"value" => $icons_services_arr,
			"description" => __("Select A Icon","TS")
		),
		array(
			"type" => "attach_image",
			"heading" => __("<B>OR</B> Import your Image", "js_ciomposer"),
			"param_name" => "ts_custom_image",
			"value" => "",
			"description" => __("Add Your Icon,size < 28x28","TS")
		),
		array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => __("Toggle content","TS"),
            "param_name" => "content",
            "value" => __("<p>Toggle content goes here, click edit button.</p>","TS"),
            "description" => __("Toggle block content.","TS")
        ),
		
		
	),
	
) );
?>