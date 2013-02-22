<?php
/*
* ----------------------------------------------------------------------------------------------------
*  Add link to the admin bar
* @PACKAGE BY HAWKTHEME
* ----------------------------------------------------------------------------------------------------
*/

class theme_options_admin_bar {

	
	/**
	* Add's new global menu, if $href is false menu is added but registred as submenuable
	*
	* $name String
	* $id String
	* $href Bool/String
	*
	* @return void
	* @author NGUYEN VUONG THANH
	**/
	function add_root_menu($name, $id, $href = false)
	{
		global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() )
		  return;

		$href = admin_url('admin.php?page=option_general.php');
		$wp_admin_bar->add_menu( array(
			'id' => $id,
			'title' => $name,
			'href' => $href 
		));
	}


	/**
   * Add's new submenu where additinal $meta specifies class, id, target or onclick parameters
   *
   * $name String
   * $link String
   * $root_menu String
   * $meta Array
   *
   * @return void
   * @author Nguyen Vuong Thanh
   **/
	function add_sub_menu($name, $link, $id, $root_menu, $meta = FALSE)
	{
		global $wp_admin_bar;
		if ( !is_super_admin() || !is_admin_bar_showing() )
		  return;

		$wp_admin_bar->add_menu( array(
		'parent' => $root_menu,
		'id' => $id,
		'title' => $name,
		'href' => $link,
		'meta' => $meta) );
	}


	/*
	* Add theme option links
	*/
	 function theme_option_links() {
		$enable_portfolio = get_theme_option('type','enable_portfolio');
		$enable_product = get_theme_option('type','enable_product');
		$enable_download = get_theme_option('type','enable_download');
		$enable_event = get_theme_option('type','enable_event');
		$enable_team = get_theme_option('type','enable_team');

		$this->add_root_menu('Theme Panel', 'TT');
		$this->add_sub_menu('General', admin_url('admin.php?page=option_general.php'), 'option_general', 'TT');
		$this->add_sub_menu('Header', admin_url('admin.php?page=option_header.php'), 'option_header', 'TT');
		$this->add_sub_menu('Footer', admin_url('admin.php?page=option_footer.php'), 'option_footer', 'TT');
		$this->add_sub_menu('Slidershow', admin_url('admin.php?page=option_slideshow.php'), 'option_slideshow', 'TT');
		$this->add_sub_menu('Blog', admin_url('admin.php?page=option_blog.php'), 'option_blog', 'TT');
		$this->add_sub_menu('Contact', admin_url('admin.php?page=option_contact.php'), 'option_contact', 'TT');
		$this->add_sub_menu('Font', admin_url('admin.php?page=option_font.php'), 'option_font', 'TT');
		$this->add_sub_menu('Style', admin_url('admin.php?page=option_style.php'), 'option_style', 'TT');
		$this->add_sub_menu('Portfolio', admin_url('admin.php?page=option_portfolio.php'), 'option_portfolio', 'TT');
		$this->add_sub_menu('Tesimonial', admin_url('admin.php?page=option_testimonial.php'), 'option_testimonial', 'TT');
	}

}


function theme_options_admin_bar_init() {
    global $theme_options_admin_bar; $theme_options_admin_bar = new theme_options_admin_bar();
}

add_action('init', 'theme_options_admin_bar_init');

?>