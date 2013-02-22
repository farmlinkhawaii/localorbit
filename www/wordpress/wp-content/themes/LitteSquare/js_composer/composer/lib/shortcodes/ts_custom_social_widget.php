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

class WPBakeryShortCode_ts_custom_social_widget extends WPBakeryShortCode {

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
            'ts_custom_social_title' => '',
            'ts_custom_social_content' => '',
            'ts_custom_social_facebook' => '',
            'ts_custom_social_twitter' => '',
            'ts_custom_social_linkedin' => '',
            'ts_custom_social_vimeo' => '',
            'ts_custom_social_dribble' => '',
            'ts_custom_social_delicious' => '',
			'ts_custom_social_youtube' => '',
			'ts_custom_social_stumbleupon' => '',
			'ts_custom_social_flickr' => '',
        ), $atts));
        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output1  = do_shortcode("[widget widget_name='Custom_Social' instance='title=".$ts_custom_social_title."&content=".$ts_custom_social_content."&facebook=".$ts_custom_social_facebook."&twitter=".$ts_custom_social_twitter."&linkedin=".$ts_custom_social_linkedin."&vimeo=".$ts_custom_social_vimeo."&dribbble=".$ts_custom_social_dribble."&delicious=".$ts_custom_social_delicious."&youtube=".$ts_custom_social_youtube."&stumbleupon=".$ts_custom_social_stumbleupon."&flickr=".$ts_custom_social_flickr."']");
		$output  = '<div class="' . $width_class . '">';
	    					
	        $output .= $output1;
	        
        $output .= '</div>';
        
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}

?>