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

class WPBakeryShortCode_ts_post_grid extends WPBakeryShortCode {

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
            'width' => '1/1',
            'el_position' => '',
            'title' => '',
			'numberposts' => '',
			'enable_descript' => '',
			'post-type' => '',
			'select_categories' => '',
			'order' => '',
			'orderby' => '',
        ), $atts));
        $width_class = wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
		$output  = '<div class="' . $width_class . '">';
	    $i = -1;
		if($numberposts == 0 || $numberposts == ""){$numberposts =4;}
		
		global $theme_options;
		$args= array(
		'post-type'=>'post',
		'order'=>$order,
		'orderby'=>$orderby,
		'numberposts'=>$numberposts,
		);
		
		
		if($select_categories != 'all'):
		$args= array(
		'post-type'=>'post',
		'order'=>$order,
		'orderby'=>$orderby,
		'category'=>$select_categories,
		'numberposts'=>$numberposts,
		);
		endif;
		$i = 0;
        $ts_post = get_posts($args);
		 wp_enqueue_script( 'prettyphoto' );
            wp_enqueue_style( 'prettyphoto' );
		$output1 =	'
		<div class="widget_recent_posts">
							<h3 class="widget-title">'.$title.'</h3>
                            <div class="row">';
		
		foreach($ts_post as $post):
			$numberposts++;
			$blog_type  	= 	get_post_meta($post->ID,'_blog_type',true);
			$blog_image 	=  	get_post_meta($post->ID,'_blog_image',true);
			$_blog_video_style 	=  	get_post_meta($post->ID,'_blog_video_thumb',true);
			$_blog_video_id 	=  	get_post_meta($post->ID,'_blog_video',true);
			$_blog_slider_id 	=  	get_post_meta($post->ID,'_blog_slider',true);
			$_blog_meta_enable 	=  	$theme_options["blog_meta_enable"];
			
			$imagethumb = '';
			$image_fullwidth ='';
			$imageid=get_post_thumbnail_id($post->ID);
			$imagethumb = wp_get_attachment_image_src($imageid,'full');
			$span_style ='';
			if($i % $numberposts == 1){
				$span_style =''; 
			}		
			$output1.='
								<dl class="span4 " '.$span_style.'>
									
                                	<dt>
	                                    <a href="'.get_permalink($post->ID).'">
                                        	<img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$imagethumb[0].'&amp;h=122&amp;w=230&amp;zc=1" alt=""></a>';
											if($blog_type == 'image'):		
             $output1.='                               <a href="'.$imagethumb[0].'" rel="prettyphoto"><span class="overlay"><img src="'.THEMESTUDIO_IMG.'/image-icon.png" alt=""></span></a>';
											elseif($blog_type == 'video'):	
												if($_blog_video_style == 'Youtube'):
             $output1.='                               <a href="http://www.youtube.com/watch?v='.$_blog_video_id.'" rel="prettyphoto"><span class="overlay"><img src="'.THEMESTUDIO_IMG.'/video-icon.png" alt=""></span></a>';											
												elseif($_blog_video_style == 'Vimeo'):
             $output1.='                               <a href="http://vimeo.com/'.$_blog_video_id.'" rel="prettyphoto"><span class="overlay"><img src="'.THEMESTUDIO_IMG.'/video-icon.png" alt=""></span></a>';											
												endif;
											elseif($blog_type == 'slider'):		
			 $output1.='                               <a href="'.$imagethumb[0].'"rel="prettyphoto[gallery'.$post->ID.']"><span class="overlay"><img src="'.THEMESTUDIO_IMG.'/gallery-icon.png" alt="" ></span></a>';						
											endif;
											
			$output1.=		          	'
                                    </dt>
                                    <dd>
                                    	<h4 class="item-title"><a href="'.get_permalink($post->ID).'">'.$post->post_title .'</a></h4>
	                                    <footer>
	                                        <ul>
	                                            <li>Date: <a href="'.get_permalink($post->ID).'">'.get_the_time('M j, Y').'</a> &nbsp;</li>
	                                            <li>'.esc_html('Posted by:','TS').' <a href="'.get_author_posts_url($post->post_author).'">'.get_the_author_meta('user_nicename',$post->post_author).'</a></li>
	                                        </ul>
	                                    </footer>';
										if($enable_descript == 'yes'):
	        $output1.=                  '<p>'.tt_substr($post->post_content ,$theme_options['blog_except_lenght']).'</p>';
										endif;
            $output1.=	          '</dd>
                                </dl>';

					$slider_id = $_blog_slider_id;
					$slider_metas = get_post_meta($slider_id,'_slider_slider',true);
					$slider_num = 1;
					if($slider_metas != null):
						foreach($slider_metas as $slider_meta):
							$output1.='<a href="'.$slider_meta["image"].'" rel="prettyphoto[gallery'.$post->ID.']" style="display:none;"></a>';
						endforeach;
					endif;
			$i++;		
		endforeach;
                                
        $output1 .=	'
	                  </div>
		
		
		';
							
	        $output .= $output1;//$output1;
	        
        $output .= '</div></div>';
        
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}

/*
Map For Client
extract(shortcode_atts(array(
            'width' => '1/2',
            'el_position' => '',
            'title' => '',
			'sum' => '',
			'descript' => '',
			'post-type' => '',
			'category' => '',
			'order' => '',
			'orderby' => '',
        ), $atts));
*/
$args=array(
  'orderby' => 'name',
  'order' => 'ASC'
  );
$categories1=get_categories($args);
$ts_cates1= array();
$ts_cates1["all"] = "all";
foreach($categories1 as $category) { 
	$ts_cates1[$category->name] = $category->term_id;
};
wpb_map( array(
	"name"		=> __("Post grid","TS"),
	"base"		=> "ts_post_grid",
	"class"		=> "",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Content', 'js_composer'),
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
			"description" => __("Enter your title.","TS")
		),
		array(
			"type" => "textfield",
			"heading" => __("Number post display","TS"),
            "param_name" => "numberposts",
            "value" => "",
            "description" => "Insert a number"
		),
		array(
			"type" => "dropdown",
			"heading" => __("Enable descript","TS"),
            "param_name" => "enable_descript",
            "value" =>  array(__("No description","TS") => "no", __("Excerpt","TS") => "yes" ),
            "description" => "Select one"
		),
		
		array(
			"type" => "dropdown",
			"heading" => __("Select a categories","TS"),
            "param_name" => "select_categories",
            "value" =>  $ts_cates1,
            "description" => "Select one"
		),
		
        array(
            "type" => "dropdown",
            "heading" => __("Order by","TS"),
            "param_name" => "orderby",
            "value" => array( "", __("Date","TS") => "date", __("ID","TS") => "ID", __("Author","TS") => "author", __("Title","TS") => "title", __("Modified","TS") => "modified", __("Random","TS") => "rand", __("Comment count","TS") => "comment_count", __("Menu order","TS") => "menu_order" ),
            "description" => __('Select how to sort retrieved posts. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Order way","TS"),
            "param_name" => "order",
            "value" => array( __("Descending","TS") => "DESC", __("Ascending","TS") => "ASC" ),
            "description" => __('Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
        ),
		
	)
) );
?>