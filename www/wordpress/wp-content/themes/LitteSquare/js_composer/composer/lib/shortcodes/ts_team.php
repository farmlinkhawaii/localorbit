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

class WPBakeryShortCode_ts_team extends WPBakeryShortCode {

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
            'name' => '',
			'images' => '',
			'descriptauthor' => '',
			'facebook' => '',
			'dribbble' => '',
			'flick' => '',
			'rss' => '',
			'skype' => '',
			'twitter' => '',
			
        ), $atts));
        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output  = '<div class="' . $width_class . '">';
	    
		$output1 =	'
			<div class="sc-staff">
				<div class="thumbnail"><img alt="" src="'.wp_get_attachment_url($images).'"></div>
				<h3>'.$name.'</h3>
				<p>'.$descriptauthor.'</p>
				<nav class="social-profiles">
					<a title="Facebook" class="s-facebook" href="'.$facebook.'">Facebook</a>
					<a title="Dribbble" class="s-dribbble" href="'.$dribbble.'">Dribbble</a>
					<a title="RSS" class="s-rss" href="'.$rss.'">RSS</a>
					<a title="Skype" class="s-skype" href="'.$skype.'">Skype</a>
					<a title="Twitter" class="s-twitter" href="'.$twitter.'">Twitter</a>
				</nav>
			</div>
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
	"name"		=> __("Team","TS"),
	"base"		=> "ts_team",
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
			"heading" => __("Name","TS"),
			"param_name" => "name",
			"value" => "",
			"description" => __("Enter Name.","TS")
		),
		array(
			"type" => "attach_image",
			"heading" => __("Author Thumb","TS"),
            "param_name" => "images",
            "value" => "",
            "description" => ""
		),
		array(
			"type" => "textarea",
			"heading" => __("Author Descript","TS"),
            "param_name" => "descriptauthor",
            "value" => "",
            "description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => __("Facebook Link","TS"),
            "param_name" => "facebook",
            "value" => "",
            "description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => __("Dribbble Link","TS"),
            "param_name" => "dribbble",
            "value" => "",
            "description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => __("Rss Link","TS"),
            "param_name" => "rss",
            "value" => "",
            "description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => __("Skype","TS"),
            "param_name" => "skype",
            "value" => "",
            "description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitter","TS"),
            "param_name" => "twitter",
            "value" => "",
            "description" => ""
		),
		
	)
) );
?>