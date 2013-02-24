<?php
/**
 * WPBakery Visual Composer shortcodes
 *
 * @package WPBakeryVisualComposer
 *
 */

class WPBakeryShortCode_VC_Button extends WPBakeryShortCode {

    protected function content($atts, $content = null) {
        $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
        extract(shortcode_atts(array(
            'color' => 'wpb_button',
            'size' => '',
            'icon' => 'none',
            'target' => '_self',
            'href' => '',
            'el_class' => '',
            'title' => __('Text on the button',"TS"),
            'position' => ''
        ), $atts));
        $output = '';
        $a_class = '';

        if ( $el_class != '' ) {
            $tmp_class = explode(" ", $el_class);
            if ( in_array("prettyphoto", $tmp_class) ) {
                wp_enqueue_script( 'prettyphoto' );
                wp_enqueue_style( 'prettyphoto' );
                $a_class .= ' prettyphoto'; $el_class = str_ireplace("prettyphoto", "", $el_class);
            }
            if ( in_array("pull-right", $tmp_class) && $href != '' ) { $a_class .= ' pull-right'; $el_class = str_ireplace("pull-right", "", $el_class); }
            if ( in_array("pull-left", $tmp_class) && $href != '' ) { $a_class .= ' pull-left'; $el_class = str_ireplace("pull-left", "", $el_class); }
        }

        if ( $target == 'same' || $target == '_self' ) { $target = ''; }
        $target = ( $target != '' ) ? ' target="'.$target.'"' : '';

        $color = ( $color != '' ) ? ' '.$color : '';
        $size = ( $size != '' ) ? ' '.$size : '';
        $icon = ( $icon != '' && $icon != 'none' ) ? ' '.$icon : '';
        $i_icon = ( $icon != '' ) ? ' <i class="icon"> </i>' : '';
        $position = ( $position != '' ) ? ' '.$position.'-button-position' : '';
        $el_class = $this->getExtraClass($el_class);

        if ( $href != '' ) {
            $output .= '<span class="wpb_button '.$color.$size.$icon.$el_class.$position.' button ">'.$title.$i_icon.'</span>';
            $output = '<a class="wpb_button_a'.$a_class.'" title="'.$title.'" href="'.$href.'"'.$target.'>' . $output . '</a>';
        } else {
            $output .= '<button class="wpb_button '.$color.$size.$icon.$el_class.$position.' button">'.$title.$i_icon.'</button>';

        }

        return $output . $this->endBlockComment('button') . "\n";
    }
}

class WPBakeryShortCode_VC_Cta_button extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        $color = $icon = $size = $target = $href = $title = $call_text = $position = $el_class = $el_position = '';
        extract(shortcode_atts(array(
            'width' => '1/2',
			'target' => '',
            'href' => '',
            'title' => __('Text on the button',"TS"),
            'call_text' => '',
			'small_text'=>'',
            'el_class' => ''
        ), $atts));
        $output = '';

        $el_class = $this->getExtraClass($el_class);

        if ( $target == 'same' || $target == '_self' ) { $target = ''; }
        if ( $target != '' ) { $target = ' target="'.$target.'"'; }

        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output1 = 	'
						<div class="hero-unit span12 alt">
                            <div class="row">
                                <div class="span9">
                                    <h1>'.$call_text.'</h1>
                                    <p>'.$small_text.'</p>
                                </div>
                                <div class="span3">
                                    <p class="button-container"><span><a class="button button-big" '.$target.' href="'.$href.'">'.$title.'</a></span></p>
                                </div>
                            </div>
                        </div>
		';
        $output  = '<div class="row-fluid">';
	        
	        $output .= $output1;
	        
        $output .= '</div>';
        
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}