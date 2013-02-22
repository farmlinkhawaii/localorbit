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

class WPBakeryShortCode_ts_services_style_1 extends WPBakeryShortCode {

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
			'is_first' => '',
			'is_circle' => '',
			'ts_icon_type' => '',
			'ts_number' => '',
			'ts_image_icon' => '',
			'ts_custom_image' => '',
			'ts_content' => '',
        ), $atts));
		
		$first = '';
		$font_circle='pull-left';
		$icon_circle='pull-left';
		if($is_circle =='yes')
		{
		$font_circle='font-circle';
		$icon_circle='icon-circle';
		}
		if($is_first == 'yes')
		{
		$first = 'first';
		}
        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output1 = 	'
						<div class="sc-teaser">
							';
		if($ts_icon_type == 'number'):					
		$output1 .=			'<div class="'.$font_circle.' '.$first.'">'.$ts_number.'</div>';
		elseif($ts_icon_type == 'image'):		
		$output1 .=			'<div class="'.$icon_circle.' '.$first.'"><img alt="" src="'.THEMESTUDIO_IMG.'/pictures/icons/'.$ts_image_icon.'.png"></div>';	
		elseif($ts_icon_type == 'custom_image'):	
		$output1 .=			'<div class="'.$icon_circle.' '.$first.'"><img alt="" src="'.wp_get_attachment_url($ts_custom_image).'"></div>';
		endif;
		$output1 .=			'
							<h3>'.$title.'</h3>
							<p>'.$content.'</p>
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
	__("teaser-1","TS") => "teaser-1",
	__("teaser-2","TS") => "teaser-2",
	__("teaser-3","TS") => "teaser-3",
	__("teaser-4","TS") => "teaser-4",
	__("teaser-5","TS") => "teaser-5",
	__("teaser-6","TS") => "teaser-6",
);
wpb_map( array(
	"name"		=> __("Services style 1","TS"),
	"base"		=> "ts_services_style_1",
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
			"description" => __("Enter your Js.","TS")
		),
		array(
			"type" => "dropdown",
			"heading" => __("User Circle for Image","TS"),
			"param_name" => "is_circle",
			"value" =>  array(__("no","TS") => "no", __("yes","TS") => "yes"),
			"description" => __("If this servicer is first, you can choice first.","TS")
		),		
		array(
			"type" => "dropdown",
			"heading" => __("Is First Services","TS"),
			"param_name" => "is_first",
			"value" =>  array(__("no","TS") => "no", __("yes","TS") => "yes"),
			"description" => __("If this servicer is first, you can choice first.","TS")
		),		
		
		array(
			"type" => "dropdown",
			"heading" => __("Icon","TS"),
			"param_name" => "ts_icon_type",
			"value" =>  array(__("Number","TS") => "number", __("Image","TS") => "image", __("Your Image","TS") => "custom_image"),
			"description" => __("Select Icon Type.","TS")
		),
		array(
			"type" => "textfield",
			"heading" => __("Number","TS"),
			"param_name" => "ts_number",
			"value" => "",
			"description" => __("Enter Your Number.","TS")
		),
		array(
			"type" => "dropdown",
			"heading" => __("<B>OR</B> Image Icon","TS"),
			"param_name" => "ts_image_icon",
			"value" => $icons_services_arr,
			"description" => __("Select A Icon","TS")
		),
		array(
			"type" => "attach_image",
			"heading" => __("<B>OR</B> Import a Image", "js_ciomposer"),
			"param_name" => "ts_custom_image",
			"value" => "",
			"description" => __("Add Your Icon,size < 28x28","TS")
		),
		array(
            "type" => "textarea_html",
            "heading" => __("Contant ","TS"),
            "param_name" => "content",
            "holder" => "div",
            "class" => "",
			"value" => __("<p>Toggle content goes here, click edit button.</p>","TS"),
            "description" => __("Imput Content of services.","TS")
        ),
		
		
	),
	
) );
?>