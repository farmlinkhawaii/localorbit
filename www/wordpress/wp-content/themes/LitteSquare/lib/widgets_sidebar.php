<?php
if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		'name' => esc_html__( 'Page Sidebar', 'TS' ),
            'description' => esc_html__( 'This is land of page sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
    
/**
*	Setup Contact side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(
	array(        
      		'name' => esc_html__( 'Contact Sidebar', 'TS' ),
            'description' => esc_html__( 'This is land of Contact sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
/**
*	Setup Contact side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(
	array(        
      		'name' => esc_html__( 'Single Portfolio', 'TS' ),
            'description' => esc_html__( 'This is land of Portfolio sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      	);
     
/**
*	Setup Blog side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(
		array(        
      		'name' => esc_html__( 'Blog Sidebar', 'TS' ),
            'description' => esc_html__( 'This is land of Blog sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
    register_sidebar(
		array(        
      		'name' => esc_html__( 'Blog Sidebar 2', 'TS' ),
            'description' => esc_html__( 'This is land of Blog sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
    register_sidebar(
		array(        
      		'name' => esc_html__( 'Single Post Sidebar', 'TS' ),
            'description' => esc_html__( 'This is land of Blog sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
			
 if ( function_exists('register_sidebar') )
    register_sidebar(
		array(        
      		'name' => esc_html__( 'Home Sidebar', 'TS' ),
            'description' => esc_html__( 'This is land of Blog sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
     if ( function_exists('register_sidebar') )
    register_sidebar(
		array(        
      		'name' => esc_html__( 'Portfolio Sidebar 1', 'TS' ),
            'description' => esc_html__( 'This is land of Blog sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
	register_sidebar(
		array(        
      		  'name' => esc_html__( 'Portfolio Sidebar 2', 'TS' ),
              'description' => esc_html__( 'This is land of Blog sidebar','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
			 )
      		);
			

global $theme_options;
$theme_options = get_option('themestudio');
//Register dynamic sidebar
$dynamic_sidebar = $theme_options['sidebar'];
if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		if ( function_exists('register_sidebar') && ($sidebar <> ''))
	    register_sidebar(array('name' => str_replace("_"," ",$sidebar),
            'description' => esc_html__( 'This is land of page sidebar','TS' ),		
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			
			'before_widget' => '<div   id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',			  
		));
	}
}


$footer_widget_style = $theme_options["footer_widgets"];
   switch($footer_widget_style)
   {
   case '1':
   if ( function_exists('register_sidebar'))
	    register_sidebar(
				array(        
				  'name' => esc_html__( 'footer widget 1', 'TS' ),
				  'description' => esc_html__( 'This is footer widget One','TS' ),
				'before_title' =>'<h3 class="widget-title">',
				'after_title' =>'</h3>',				  
				  'before_widget' => '<div class="span12 %1$s widget %2$s">',
				  'after_widget' => '</div>',
				)
      		);
   break;
   case '2':
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 1', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span6 %1$s widget %2$s">',
			  'after_widget' => '</div>',		  
			 )
      		);
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 2', 'TS' ),
              'description' => esc_html__( 'This is footer widget Two','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span6 %1$s widget %2$s">',
			  'after_widget' => '</div>',			  
			 )
      		);
   break;
   case '3':
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 1', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span4 %1$s widget %2$s">',
			  'after_widget' => '</div>',			  
			 )
      		);
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 2', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span4 %1$s widget %2$s">',
			  'after_widget' => '</div>',			  
			 )
      		);
	if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 3', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span6 %1$s widget %2$s">',
			  'after_widget' => '</div>',				  
			 )
      		);
			
   break;
   case '4':
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 1', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span3 %1$s widget %2$s">',
			  'after_widget' => '</div>',				  
			 )
      		);
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 2', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span3 %1$s widget %2$s">',
			  'after_widget' => '</div>',			  
			 )
      		);
   if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 3', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span3 %1$s widget %2$s">',
			  'after_widget' => '</div>',			  
			 )
      		);
	if ( function_exists('register_sidebar') )
	    register_sidebar(
      		array(        
      		  'name' => esc_html__( 'footer widget 4', 'TS' ),
              'description' => esc_html__( 'This is footer widget One','TS' ),
			'before_title' =>'<h3 class="widget-title">',
			'after_title' =>'</h3>',			  
			  'before_widget' => '<div class="span3 %1$s widget %2$s">',
			  'after_widget' => '</div>',			  
			 )
      		);
			
   break;
   }
?>