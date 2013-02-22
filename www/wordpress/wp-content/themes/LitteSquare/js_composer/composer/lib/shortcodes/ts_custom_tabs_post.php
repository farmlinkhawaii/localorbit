<?php
/*
TC VISUAL SHORTCODE FOR TABS POST.
AUTHOR : VTHANH_88
*/
class WPBakeryShortCode_ts_custom_tabs_post extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
            'width' => '1/2',
            'el_position' => '',
            'tabs_post_items' => '',
			
        ), $atts));
        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output1 = 	do_shortcode("[widget widget_name=Custom_Tabs_Posts instance='items=".$tabs_post_items."']");
        $output  = '<div class="' . $width_class . '">';
	        
	        $output .= $output1;
	        
        $output .= '</div>';
        
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}
?>