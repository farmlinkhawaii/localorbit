<?php

if ( !isset($content_width) ) {
	$content_width = 960;
}
if ( function_exists('add_theme_support') ) {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'nav_menus' );
}
add_editor_style();

/*
Register Post Type
*/
add_action('init', 'portfolio_post_type',20);
add_action('init', 'slider_post_type');

function portfolio_post_type() 
{
	$labels = array(
		'name' => _x('Portfolio', 'post type general name', 'TS'),
		'singular_name' => _x('Portfolio', 'post type singular name', 'TS'),
		'add_new' => _x('Add New', 'portfolio', 'TS'),
		'all_items' => __('All Portfolio', 'TS'),
		'add_new_item' => __('Add New Portfolio', 'TS'),
		'edit_item' => __('Edit Portfolio', 'TS'),
		'new_item' => __('New Portfolio', 'TS'),
		'view_item' => __('View Portfolio', 'TS'),
		'search_items' => __('Search Portfolio', 'TS'),
		'not_found' =>  __('No Portfolio Found', 'TS'),
		'not_found_in_trash' => __('No Portfolio Found in Trash', 'TS'), 
		'parent_item_colon' => ''
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug' => 'portfolio-view', 'with_front' => true),
		'query_var' => true,
		'show_in_nav_menus'=> false,
		'supports' => array('title', 'thumbnail', 'excerpt', 'editor'),
		'menu_position' =>20
	);
	
	register_post_type( 'portfolio' , $args );	
	
	register_taxonomy('portfolio-category', 
		array('portfolio'), 
		array(
			'hierarchical' => true, 
			'label' => 'Categories', 
			'singular_label' => 'Categories', 
			'rewrite' => true,
			'query_var' => true
		)
	);
}

function slider_post_type() 
{
	$labels = array(
		'name' => _x('Sliders', 'post type general name', 'TS'),
		'singular_name' => _x('TS Slider', 'post type singular name', 'TS'),
		'add_new' => _x('Add New', 'TS Slider', 'TS'),
		'all_items' => __('All Slider', 'TS'),
		'add_new_item' => __('Add New Slider', 'TS'),
		'edit_item' => __('Edit Slider', 'TS'),
		'new_item' => __('New Slider', 'TS'),
		'view_item' => __('View Slider', 'TS'),
		'search_items' => __('Search Slider', 'TS'),
		'not_found' =>  __('No Slider Found', 'TS'),
		'not_found_in_trash' => __('No Slider Found in Trash', 'TS'), 
		'parent_item_colon' => ''
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug' => 'slider', 'with_front' => true),
		'query_var' => true,
		'show_in_nav_menus'=> false,
		'supports' => array('title'),
		'menu_position' =>20
	);
	
	register_post_type( 'Slider' , $args );	
	
	/*
	register_taxonomy('slider-category', 
		array('slider'), 
		array('hierarchical' => true, 
		'label' => 'Categories', 
		'singular_label' => 'Categories', 
		'rewrite' => true,
		'query_var' => true
	));
	*/
}

add_filter('manage_edit-portfolio_columns', 'portfolio_edit_columns');
add_filter('manage_edit-slider_columns', 'pricing_table_edit_columns');
add_action('manage_posts_custom_column', 'posts_custom_columns', 10, 2);

function portfolio_edit_columns($columns)
{
	$newcolumns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Title',
		'portfolio-category' => 'Categories'
	);
	
	$columns= array_merge($newcolumns, $columns);
	
	return $columns;
}

function pricing_table_edit_columns($columns)
{
	$newcolumns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Title',
		'slider-category' => 'Categories'
	);
	
	$columns= array_merge($newcolumns, $columns);
	
	return $columns;
}

function posts_custom_columns($column)
{
	global $post;
	
	switch ($column) {
		case 'portfolio-category':
		echo get_the_term_list($post->ID, 'portfolio-category', '', ', ','');
		break;
		case 'slider-category':
		//echo get_the_term_list($post->ID, 'slider-category', '', ', ','');
		break;
	}
}


/*
Register Meta Box
*/
add_filter( 'cmb_meta_boxes', 'global_metaboxes' );
add_filter( 'cmb_meta_boxes', 'page_metaboxes' );
add_filter( 'cmb_meta_boxes', 'portfolio_metaboxes' );
add_filter( 'cmb_meta_boxes', 'blog_metaboxes' );

add_filter( 'cmb_meta_boxes', 'pricing_table_metaboxes' );


function global_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_general_';
	
/*
EASING 
*/
$ts_easing  = array(
			array('value'=>'jswing','name'=>'jswing'),
			array('value'=>'def','name'=>'def'),
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeInOutQuad','name'=>'easeInOutQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeInOutQuart','name'=>'easeInOutQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeInOutQuint','name'=>'easeInOutQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeInOutSine','name'=>'easeInOutSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeInOutExpo','name'=>'easeInOutExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeInOutCirc','name'=>'easeInOutCirc'),
			array('value'=>'easeInElastic','name'=>'easeInElastic'),
			array('value'=>'easeInOutElastic','name'=>'easeInOutElastic'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeInOutBack','name'=>'easeInOutBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
			array('value'=>'easeInOutBounce','name'=>'easeInOutBounce'),		
);
/*
easing out
*/
$ts_easing_out = array(
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
);
/*
easing in
*/
$ts_easing_in = array(
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
);
	
	
	$meta_boxes[] = array(
		'id'         => 'general_metabox',
		'title'      => 'General Options',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			/*array(
				'name'    => 'Header Element',
				'desc'    => '',
				'id'      => $prefix .'header',
				'type'    => 'select',
				'std'     => 'none',
				'options' => array(
					array( 'value' => '', 'name' => 'Page Title' ),
					array( 'value' => 'flex-slider', 'name' => 'Flex Slider' ),
					array( 'value' => 'zaccordion-slider', 'name' => 'zAccordion Slider' ),
					array( 'value' => 'slidesjs-slider-1', 'name' => 'SlidesJS Slider Full' ),
					array( 'value' => 'slidesjs-slider-2', 'name' => 'SlidesJS Slider Part' ),
					array( 'value' => 'pre-content', 'name' => 'Pre Content' ),
				),
			),
			*/
			array(
				'name' => 'Sub Title',
				'desc' => '',
				'id'   => $prefix .'subtitle',
				'type' => 'text_large',
			),
			/*
			array(
				'name' => 'Pre Content',
				'desc' => '',
				'id'   => $prefix .'precontent',
				'type' => 'wysiwyg',
			),
			*/
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'general_metabox',
		'title'      => 'General Options',
		'pages'      => array( 'post', 'portfolio' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Sub Title',
				'desc' => '',
				'id'   => $prefix .'subtitle',
				'type' => 'text_large',
			),
		),
	);

	return $meta_boxes;
}

function page_metaboxes( array $meta_boxes ) {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_page_';
	
/*
EASING 
*/
$ts_easing  = array(
			array('value'=>'jswing','name'=>'jswing'),
			array('value'=>'def','name'=>'def'),
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeInOutQuad','name'=>'easeInOutQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeInOutQuart','name'=>'easeInOutQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeInOutQuint','name'=>'easeInOutQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeInOutSine','name'=>'easeInOutSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeInOutExpo','name'=>'easeInOutExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeInOutCirc','name'=>'easeInOutCirc'),
			array('value'=>'easeInElastic','name'=>'easeInElastic'),
			array('value'=>'easeInOutElastic','name'=>'easeInOutElastic'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeInOutBack','name'=>'easeInOutBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
			array('value'=>'easeInOutBounce','name'=>'easeInOutBounce'),		
);
/*
easing out
*/
$ts_easing_out = array(
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
);
/*
easing in
*/
$ts_easing_in = array(
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
);
	
	$meta_boxes[] = array(
		'id'         => 'page_metabox',
		'title'      => 'Page Templates',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(		
			array(
				'name'    => 'Page Template',
				'desc'    => '',
				'id'      => $prefix .'template',
				'type'    => 'select',
				'options' => array(
					array( 'value' => 'default', 'name' => 'Page Default' ),
					array( 'value' => 'blog', 'name' => 'Blog' ),
					array( 'value' => 'portfolio', 'name' => 'Portfolio' ),
					/*
					array( 'value' => 'contact', 'name' => 'Contact' ),
					array( 'value' => 'sitemap', 'name' => 'Sitemap' ),
					*/
				),
			),	
			array(
				'name'    => 'Page Layout',
				'desc'    => '',
				'id'      => $prefix .'default',
				'type'    => 'select',
				'std'     => 'fw',
				'options' => array(
					array( 'value' => 'fw', 'name' => 'Full Width' ),
					array( 'value' => 'lb', 'name' => 'Left Sidebar' ),
					array( 'value' => 'rb', 'name' => 'Right Sidebar' ),
				),
			),
			array(
				'name'    => 'Blog Layout',
				'desc'    => '',
				'id'      => $prefix .'_blog_style',
				'type'    => 'select',
				'std'     => 'fw',
				'options' => array(
					array( 'value' => 'lb', 'name' => 'Left Sidebar' ),
					array( 'value' => 'rb', 'name' => 'Right Sidebar' ),
				),
			),
			
			array(
				'name'    => 'Display per Page',
				'desc'    => '',
				'id'      => $prefix .'portfolio_num',
				'type'    => 'select',
				'std'     => '10',
				'options' => array(
					array( 'value' => '1', 'name' => '1' ),
					array( 'value' => '2', 'name' => '2' ),
					array( 'value' => '3', 'name' => '3' ),
					array( 'value' => '4', 'name' => '4' ),
					array( 'value' => '5', 'name' => '5' ),
					array( 'value' => '6', 'name' => '6' ),
					array( 'value' => '7', 'name' => '7' ),
					array( 'value' => '8', 'name' => '8' ),
					array( 'value' => '9', 'name' => '9' ),
					array( 'value' => '10', 'name' => '10' ),
					array( 'value' => '11', 'name' => '11' ),
					array( 'value' => '12', 'name' => '12' ),
					array( 'value' => '13', 'name' => '13' ),
					array( 'value' => '14', 'name' => '14' ),
					array( 'value' => '15', 'name' => '15' ),
					array( 'value' => '16', 'name' => '16' ),
					array( 'value' => '17', 'name' => '17' ),
					array( 'value' => '18', 'name' => '18' ),
					array( 'value' => '19', 'name' => '19' ),
					array( 'value' => '20', 'name' => '20' ),
				),
			),
			array(
				'name'    => 'JQuery Filter',
				'desc'    => '',
				'id'      => 'portfolio_filter',
				'type'    => 'select',
				'std'     => '1',
				'options' => array(
					array( 'value' => '0', 'name' => 'Disable' ),
					array( 'value' => '1', 'name' => 'Enable' ),
				),
			),
			array(
				'name'    => 'Portfolio Category',
				'desc'    => '',
				'id'      => 'pages_portfolio_Category',
				'type'    => 'select_portfolio_category',
				'std'     => 'All',
				
			),
			
			
			array(
				'name'    => 'Page Sidebar',
				'desc'    => '',
				'id'      => $prefix .'sidebar',
				'type'    => 'select_sidebar',
				'std'     => ''
			),
		),
	);
$meta_boxes[] = array(
		'id'         => 'page_portfolio_metabox',
		'title'      => 'Portfolio Layout Options',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'hight',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Display per Page',
				'desc'    => '',
				'id'      => $prefix .'portfolio_num',
				'type'    => 'select',
				'std'     => '10',
				'options' => array(
					array( 'value' => '1', 'name' => '1' ),
					array( 'value' => '2', 'name' => '2' ),
					array( 'value' => '3', 'name' => '3' ),
					array( 'value' => '4', 'name' => '4' ),
					array( 'value' => '5', 'name' => '5' ),
					array( 'value' => '6', 'name' => '6' ),
					array( 'value' => '7', 'name' => '7' ),
					array( 'value' => '8', 'name' => '8' ),
					array( 'value' => '9', 'name' => '9' ),
					array( 'value' => '10', 'name' => '10' ),
					array( 'value' => '11', 'name' => '11' ),
					array( 'value' => '12', 'name' => '12' ),
					array( 'value' => '13', 'name' => '13' ),
					array( 'value' => '14', 'name' => '14' ),
					array( 'value' => '15', 'name' => '15' ),
					array( 'value' => '16', 'name' => '16' ),
					array( 'value' => '17', 'name' => '17' ),
					array( 'value' => '18', 'name' => '18' ),
					array( 'value' => '19', 'name' => '19' ),
					array( 'value' => '20', 'name' => '20' ),
				),
			),
			array(
				'name'    => 'JQuery Filter',
				'desc'    => '',
				'id'      => $prefix .'portfolio_filter',
				'type'    => 'select',
				'std'     => '1',
				'options' => array(
					array( 'value' => '0', 'name' => 'Disable' ),
					array( 'value' => '1', 'name' => 'Enable' ),
				),
			),
			array(
				'name'    => 'Gallery Style',
				'desc'    => '',
				'id'      => $prefix .'portfolio_gallery',
				'type'    => 'select',
				'std'     => '0',
				'options' => array(
					array( 'value' => '0', 'name' => 'Disable' ),
					array( 'value' => '1', 'name' => 'Enable' ),
				),
			),
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'page_blog_metabox',
		'title'      => 'Blog Layout Options',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Category',
				'desc'    => '',
				'id'      => $prefix .'blog_cat',
				'type'    => 'taxonomy_select',
				'taxonomy'=> 'category',
			),
			array(
				'name'    => 'Display per Page',
				'desc'    => '',
				'id'      => $prefix .'blog_num',
				'type'    => 'select',
				'std'     => '10',
				'options' => array(
					array( 'value' => '1', 'name' => '1' ),
					array( 'value' => '2', 'name' => '2' ),
					array( 'value' => '3', 'name' => '3' ),
					array( 'value' => '4', 'name' => '4' ),
					array( 'value' => '5', 'name' => '5' ),
					array( 'value' => '6', 'name' => '6' ),
					array( 'value' => '7', 'name' => '7' ),
					array( 'value' => '8', 'name' => '8' ),
					array( 'value' => '9', 'name' => '9' ),
					array( 'value' => '10', 'name' => '10' ),
					array( 'value' => '11', 'name' => '11' ),
					array( 'value' => '12', 'name' => '12' ),
					array( 'value' => '13', 'name' => '13' ),
					array( 'value' => '14', 'name' => '14' ),
					array( 'value' => '15', 'name' => '15' ),
					array( 'value' => '16', 'name' => '16' ),
					array( 'value' => '17', 'name' => '17' ),
					array( 'value' => '18', 'name' => '18' ),
					array( 'value' => '19', 'name' => '19' ),
					array( 'value' => '20', 'name' => '20' ),
				),
			),
		),
	);

	

	return $meta_boxes;
}





function blog_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_blog_';

	$meta_boxes[] = array(
		'id'         => 'blog_metabox',
		'title'      => 'Blog Options',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(	
			
			array(
				'name'    => 'Blog Feature Type',
				'desc'    => '',
				'id'      => $prefix .'type',
				'type'    => 'select',
				'options' => array(
					array( 'value' => 'image', 'name' => 'Image' ),
					array( 'value' => 'video', 'name' => 'Video' ),
					array( 'value' => 'slider', 'name' => 'Slider' ),
					array( 'value' => 'gallery', 'name' => 'Gallery' ),
				),
			),
			array(
				'name' => 'Image URL',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix .'image',
				'type' => 'image',
			),
			array(
				'name' 		=> 'Thumbnail URL',
				'desc' 		=> 'Upload an image or enter an URL.',
				'id'   		=> $prefix .'video_thumb',
				'type' 		=> 'select',
				'options' => array(
					array( 'value' => 'Youtube', 'name' => 'Youtube' ),
					array( 'value' => 'Vimeo', 'name' => 'Vimeo' ),
				)
			),
			array(
				'name' 		=> 'Video URL',
				'desc' 		=> 'This theme only supports video from Youtube and Vimeo.',
				'id'   		=> $prefix .'video',
				'type' 		=> 'text_large',
			),
			array(
				'name' => 'Select a Slides',
        		'desc' => __('Upload as many slides you want on this page, then drag and drop to arrange them.','TS'),
        		'id' => $prefix.'slider',
        		'type' => 'selectslider',
        		
        		),
			array(
				'name' => 'Select a Gallery',
        		'desc' => __('Upload as many slides you want on this page, then drag and drop to arrange them.','TS'),
        		'id' => $prefix.'gallery',
        		'type' => 'selectgallery',
        		
        		),

		
		),
	);

	return $meta_boxes;
}



function portfolio_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_portfolio_';

/*
EASING 
*/
$ts_easing  = array(
			array('value'=>'jswing','name'=>'jswing'),
			array('value'=>'def','name'=>'def'),
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeInOutQuad','name'=>'easeInOutQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeInOutQuart','name'=>'easeInOutQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeInOutQuint','name'=>'easeInOutQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeInOutSine','name'=>'easeInOutSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeInOutExpo','name'=>'easeInOutExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeInOutCirc','name'=>'easeInOutCirc'),
			array('value'=>'easeInElastic','name'=>'easeInElastic'),
			array('value'=>'easeInOutElastic','name'=>'easeInOutElastic'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeInOutBack','name'=>'easeInOutBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
			array('value'=>'easeInOutBounce','name'=>'easeInOutBounce'),		
);
/*
easing out
*/
$ts_easing_out = array(
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
);
/*
easing in
*/
$ts_easing_in = array(
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
);
	$meta_boxes[] = array(
		'id'         => 'portfolio_metabox',
		'title'      => 'Portfolio Options',
		'pages'      => array( 'portfolio' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(	
			array(
				'name' => 'Client Name',
				'desc' => 'Clients name of portfolio.',
				'id'   => $prefix .'client',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Website URL',
				'desc' => 'A website to actual portfolio url.',
				'id'   => $prefix .'website',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Enable Feature Work',
				'desc' => 'The Feature work will display below post.',
				'id'   => $prefix .'enable_feature',
				'type' => 'checkbox',
				'std' => '1',
			),			
			array(
				'name'    => 'Portfolio Type',
				'desc'    => '',
				'id'      => $prefix .'type',
				'type'    => 'select',
				'options' => array(
					array( 'value' => 'image', 'name' => 'Image' ),
					array( 'value' => 'video', 'name' => 'Video' ),
					array( 'value' => 'slider', 'name' => 'Slider' ),
				),
			),
			array(
				'name' => 'Image URL',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix .'image',
				'type' => 'image',
			),
			array(
				'name' 		=> 'Thumbnail URL',
				'desc' 		=> 'Upload an image or enter an URL.',
				'id'   		=> $prefix .'video_thumb',
				'type' 		=> 'select',
				'options' => array(
					array( 'value' => 'Youtube', 'name' => 'Youtube' ),
					array( 'value' => 'Vimeo', 'name' => 'Vimeo' ),
				)
			),
			array(
				'name' 		=> 'Video ID',
				'desc' 		=> 'This theme only ID video from Youtube and Vimeo.',
				'id'   		=> $prefix .'video',
				'type' 		=> 'text_large',
			),
			array(
				'name' => 'Select a Slides',
        		'desc' => __('Upload as many slides you want on this page, then drag and drop to arrange them.','TS'),
        		'id' => $prefix.'slider',
        		'type' => 'selectslider',
        		
        		),
			array(
				'name'    => 'Portfolio Thumb width',
				'desc'    => '',
				'id'      => 'portfolio_thumb_width',
				'type'    => 'select',
				'std'     => 'one-third',
				'options' => array(
					array( 'value' => 'one-third', 'name' => 'One Third' ),
					array( 'value' => 'two-third', 'name' => 'Two Third' ),
					array( 'value' => 'three-third', 'name' => 'Three Third' ),
				),
			),
		
		),
	);

	return $meta_boxes;
}

function pricing_table_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_slider_';

/*
EASING 
*/
$ts_easing  = array(
			array('value'=>'jswing','name'=>'jswing'),
			array('value'=>'def','name'=>'def'),
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeInOutQuad','name'=>'easeInOutQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeInOutQuart','name'=>'easeInOutQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeInOutQuint','name'=>'easeInOutQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeInOutSine','name'=>'easeInOutSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeInOutExpo','name'=>'easeInOutExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeInOutCirc','name'=>'easeInOutCirc'),
			array('value'=>'easeInElastic','name'=>'easeInElastic'),
			array('value'=>'easeInOutElastic','name'=>'easeInOutElastic'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeInOutBack','name'=>'easeInOutBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
			array('value'=>'easeInOutBounce','name'=>'easeInOutBounce'),		
);
/*
easing out
*/
$ts_easing_out = array(
			array('value'=>'easeOutQuad','name'=>'easeOutQuad'),
			array('value'=>'easeOutCubic','name'=>'easeOutCubic'),
			array('value'=>'easeOutQuart','name'=>'easeOutQuart'),
			array('value'=>'easeOutQuint','name'=>'easeOutQuint'),
			array('value'=>'easeOutSine','name'=>'easeOutSine'),
			array('value'=>'easeOutExpo','name'=>'easeOutExpo'),
			array('value'=>'easeOutCirc','name'=>'easeOutCirc'),
			array('value'=>'easeOutBack','name'=>'easeOutBack'),
			array('value'=>'easeOutBounce','name'=>'easeOutBounce'),
);
/*
easing in
*/
$ts_easing_in = array(
			array('value'=>'easeInQuad','name'=>'easeInQuad'),
			array('value'=>'easeInCubic','name'=>'easeInCubic'),
			array('value'=>'easeInQuart','name'=>'easeInQuart'),
			array('value'=>'easeInQuint','name'=>'easeInQuint'),
			array('value'=>'easeInSine','name'=>'easeInSine'),
			array('value'=>'easeInExpo','name'=>'easeInExpo'),
			array('value'=>'easeInCirc','name'=>'easeInCirc'),
			array('value'=>'easeInBack','name'=>'easeInBack'),
			array('value'=>'easeInBounce','name'=>'easeInBounce'),
);
	
	$meta_boxes[] = array(
		'id'         => 'pricing_table_1_metabox',
		'title'      => 'Slide',
		'pages'      => array( 'slider' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(	
			array(
				'name' => 'Slides',
        		'desc' => __('Upload as many slides you want on this page, then drag and drop to arrange them.','TS'),
        		'id' => $prefix.'slider',
        		'type' => 'slider',
        		'std' => array (
        			1 => array (
        				'title' => 'Slide 1',
        				'image' => '',
        				'link' => '',
        				'desc' => ''
        			),
        		),
			),
		),
	);
	/*$meta_boxes[] = array(
		'id'         => 'slide_static_content',
		'title'      => 'Slide Type',
		'pages'      => array( 'slider' ), // Post type
		'context'    => 'normal',
		'priority'   => 'low',
		'show_names' => true, // Show field names on the left
		'fields'     => array(	
				array(
				'name'    => 'Slider',
				'desc'    => '',
				'id'      => $prefix .'default_slider',
				'type'    => 'select',
				'std'     => 'fw',
				'options' => array(
					array( 'value' => 'sb', 'name' => 'Static Baner' ),
					array( 'value' => 'ns', 'name' => 'Nivo Slider' ),
					array( 'value' => 'scs', 'name' => 'Static content + Slider' ),
					array( 'value' => 'ly', 'name' => 'Layer Slider' ),
				),
			),
		),
	);
	$meta_boxes[] = array(
		'id'         => 'slide_metabox',
		'title'      => 'Slide Type',
		'pages'      => array( 'slider' ), // Post type
		'context'    => 'normal',
		'priority'   => 'low',
		'show_names' => true, // Show field names on the left
		'fields'     => array(	
				array(
				'name'    => 'Slider',
				'desc'    => '',
				'id'      => $prefix .'_banner_type',
				'type'    => 'text_medium',
				'std'     => 'fw',
				
			),
		),
	);
	*/
	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );

function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once THEMESTUDIO_ADMIN .'/metaboxes/init.php';

}
