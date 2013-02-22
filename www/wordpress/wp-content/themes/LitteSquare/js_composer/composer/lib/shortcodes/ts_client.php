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

class WPBakeryShortCode_ts_client extends WPBakeryShortCode {

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
			'images' => '',
        ), $atts));
        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output  = '<div class="' . $width_class . '">';
	    $images = explode( ',', $images);
        $i = -1;

       
		$output1 =	'
		<section id="clients">
			<h3><span>'.$title.'</span></h3>
			<div class="inner">
				<div class="inner">
					<ul>';
					 foreach ( $images as $attach_id ) {
							$output1 .= '<li><img alt="" src="'.wp_get_attachment_url($attach_id).'"></li>';
							}
		
		$output1 .=	'</ul>
				</div>
			</div>
		</section>
		
		
		';
							
	        $output .= $output1;//$output1;
	        
        $output .= '</div>';
        
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}

/*
Map For Client
*/
wpb_map( array(
	"name"		=> __("Client","TS"),
	"base"		=> "ts_client",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Content',"TS"),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title","TS"),
			"param_name" => "title",
			"value" => "",
			"description" => __("Enter title.","TS")
		),
		array(
			"type" => "attach_images",
			"heading" => __("Images","TS"),
            "param_name" => "images",
            "value" => "",
            "description" => ""
		),
	)
) );
?>