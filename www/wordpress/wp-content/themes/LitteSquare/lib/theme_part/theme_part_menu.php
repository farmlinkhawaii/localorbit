<?php 
/*
* ----------------------------------------------------------------------------------------------------
* MENU FUNCTIONS
* @PACKAGE BY TT
* ----------------------------------------------------------------------------------------------------
*/
/*------------------------------------------------------------------------
*Top Menu
------------------------------------------------------------------------*/
function ts_theme_top_wp_nav() 
{
	global $theme_options;
	$level = $theme_options["menu_level"];
	$args = array( 
		'container' => 'nav',
		'container_id' => 'top-menu', 
		'container_class' =>'span8', 
		'menu_class' => 'sf-menu sf-js-enabled',
		'fallback_cb' => 'theme_top_wp_page_menu', 
		'menu' => 'Main Menu',
		'depth' => $level,
	);
	wp_nav_menu($args); 
}

/*
		"link_before"=>"<p class="floatLeft" >",
		"link_after" => "</p><span></span>",
*/
/*------------------------------------------------------------------------
*Top Page Menu
------------------------------------------------------------------------*/
function theme_top_wp_page_menu() 
{
	global $theme_options;
	$level = $theme_options["menu_level"];
	$args = array(
		'title_li' => '0',
		'sort_column' => 'menu_order',
		'depth' => $level,
	);
	
	echo '
	<nav  class="span8">
	  <ul class="sf-menu sf-js-enabled">'.
		 		wp_list_pages($args).'
	  </ul>
	</nav>';

}


/*------------------------------------------------------------------------
*Bottom Menu
------------------------------------------------------------------------*/
function theme_bottom_wp_nav() 
{

	$args = array( 
			'container' => 'nav',
			'container_id' => 'bottom-menu', 
			'container_class' =>'bottom-menu-container', 
			'menu_class' => 'bottom-menu-class clearfix', 
			'menu' => 'bottom menu',
			'depth' => 1
	);
	wp_nav_menu($args); 

}
?>