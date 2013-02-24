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

class WPBakeryShortCode_ts_contact extends WPBakeryShortCode {

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
            'form_id'=> ''
        ), $atts));

        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder

        $output = '';
        $output  = '<div class="' . $width_class . '">';
		if($form_id <> '0'){
        $output .=  do_shortcode('[contact-form-7 id="'.$form_id.'"]')  ;
		}
        $output .= '</div>';
        return $output;
    }
}

/*
 * Settings array to setup shortcode "Hello world"
 * base param is required.
 *
 * Mapping examples: $PLUGIN_DIR/config/map.php
 *
 * name - used in content elements menu and shortcode edit screen.
 * base - shortcode base. Example my_hello_world
 * class - helper class to target your shortcode in css in visual composer edit mode
 * icon - in order to add icon for your shortcode in dropdown menu, add class name here and style it in
 *          your own css file. Note: bootstrap icons supported.
 * controls - in visual composer mode shortcodes can have different controls (popup_delete, edit_popup_delete, size_delete, popup_delete, full).
                Default is full.
 * params - array which holds your shortcode params. This params will be editable in shortcode settings page.
 *
 * Available param types:
 *
 * textarea_html (only one html textarea is permitted per shortcode)
 * textfield - simple input field,
 * dropdown - dropdown element with set of available options,
 * attach_image - single image selection,
 * attach_images - multiple images selection,
 * exploded_textarea - textarea, where each line will be imploded with comma (,),
 * posttypes - checkboxes with available post types,
 * widgetised_sidebars - dropdown element with set of available widget regions,
 * textarea - simple textarea,
 * textarea_raw_html - textarea, it's content will be codede into base64 (this allows you to store raw js or raw html code).
 *
 */
$args2 = array(
'post_type'=>'wpcf7_contact_form',
);
$ctf7s = get_posts($args2);
$ts_ctf7= array();
$ts_ctf7["0"]='None.';
foreach($ctf7s as $ctf7) { 
	$ts_ctf7[$ctf7->post_title] = $ctf7->ID;
};
wpb_map( array(
    "base"      => "ts_contact",
    "name"      => __("Contact form 7","TS"),
    "class"     => "div",
	"wrapper_class" => "clearfix",
    "icon"      => "icon-heart",
	"controls" =>"edit_delete",
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => __("Enter contact form 7 id","TS"),
            "param_name" => "form_id",
            "value" => $ts_ctf7,
            "description" => __("Contact form 7 id.Plz Install Plugin Contact Form 7 first")
        )
    )
) );
?>
