<?php

/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
//define('NHP_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('NHP_Options')){
	require_once( dirname( __FILE__ ) . '/options/options.php' );
}

/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook',"TS"),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>',"TS"),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function
//add_filter('ts-options-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function
//add_filter('ts-options-args-twenty_eleven', 'change_framework_args');









/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
//$args['dev_mode'] = true;

//google api key MUST BE DEFINED IF YOU WANT TO USE GOOGLE WEBFONTS
//$args['google_api_key'] = 'AIzaSyA04appLbsaYq_3r9mGB64sjE7Y5Uw-99A';

//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>',"TS");

//Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
										'link' => 'http://twitter.com/lee__mason',
										'title' => 'Folow me on Twitter', 
										'img' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_322_twitter.png'
										);
$args['share_icons']['linked_in'] = array(
										'link' => 'http://uk.linkedin.com/pub/lee-mason/38/618/bab',
										'title' => 'Find me on LinkedIn', 
										'img' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_337_linked_in.png'
										);

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = 'themestudio';

//Custom menu icon
//$args['menu_icon'] = '';
global $theme_options;
$theme_options = get_option('themestudio');

$custom_theme_name = $theme_options['custom_theme_name'];
if(!isset($custom_theme_name)){
	$custom_theme_name = TS_THEME_NAME;
}
//Custom menu title for options page - default is "Options"
$args['menu_title'] = $custom_theme_name.' Options';// __('Theme Options',"TS");


//Custom Page Title for options page - default is "Options"
$args['page_title'] = __($custom_theme_name.' Options',"TS");

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "ts_theme_options"
$args['page_slug'] = 'ts_theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 27;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

//Want to disable the sections showing as a submenu in the admin? uncomment this line
$args['allow_sub_menu'] = false;
		
//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		
// $args['help_tabs'][] = array(
// 							'id' => 'ts-options-1',
// 							'title' => __('Theme Information 1',"TS"),
// 							'content' => __('<p>This is the tab content, HTML is allowed.</p>',"TS")
// 							);
// $args['help_tabs'][] = array(
// 							'id' => 'ts-options-2',
// 							'title' => __('Theme Information 2',"TS"),
// 							'content' => __('<p>This is the tab content, HTML is allowed.</p>',"TS")
// 							);

//Set the Help Sidebar for the options page - no sidebar by default										
//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>',"TS");

// Set detault sidebars
$sidebar = array('primary-sidebar'=>'Primary Sidebar','secondary-sidebar'=>'Secondary Sidebar');

//General
$number_10 = array('Select',1,2,3,4,5,6,7,8,9,10);
$number_15 = array('Select',1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
$number_20 = array('Select',1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
$number_9_31 = array('Select',9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);

$webfonts = array();


$font_size = array();
for ($s = 9; $s < 40; $s++){ 
	$font_size[$s] = $s;

}
global $style_font_google;
$font_family = $style_font_google;
$font_color = '#000000';
$font_weight = array('normal'=>'Normal','bold'=>'Bold','bolder'=>'Bolder');		

//Style Skins
$style_skins_url = THEMESTUDIO_BASE_URL .'/assets/css/skins/thumb/';
$style_skins_path = THEMESTUDIO_BASE .'/assets/css/skins/';
$style_skins = array();
if ( is_dir($style_skins_path) ) {
    if ($style_skins_dir = opendir($style_skins_path) ) { 
        while ( ($style_skins_file = readdir($style_skins_dir)) !== false ) {
            if ( stristr($style_skins_file, ".css") !== false ) {
                $style_skins[$style_skins_file] = $style_skins_url . str_replace("css", "png", $style_skins_file);
            }
        }    
    }
}
ksort($style_skins);

//Style Pattern
$style_bg_url = THEMESTUDIO_BASE_URL .'/assets/images/background/thumb/';
$style_bg_path = THEMESTUDIO_BASE .'/assets/images/background/';
$style_bg = array();
$style_bg[''] = $style_bg_url . 'none.png';
if ( is_dir($style_bg_path) ) {
    if ($style_bg_dir = opendir($style_bg_path) ) { 
        while ( ($style_bg_file = readdir($style_bg_dir)) !== false ) {
            if ( stristr($style_bg_file, ".png") !== false ) {
					$style_bg[$style_bg_file] = $style_bg_url . $style_bg_file;
            }
        }    
    }
}
ksort($style_bg);

//home modules
$homepage_blocks = array(
	"enabled" => array (
		"placebo" => "placebo", //REQUIRED!
		"home_slider" => "Slider",
		"home_tagline" => "Tagline",
		"home_highlights" => "Highlights",
		"home_portfolio" => "Portfolio Items",
		"home_blog" => "Blog Posts",
		"home_staff" => "Staff",
		"home_widgets" => "Widgets",
		"home_static_page" => "Static Page"
	),
	"disabled" => array (
		"placebo" => "placebo", //REQUIRED!
		"custom_module_one" => "Custom Module 1",
		"custom_module_two" => "Custom Module 2",
		"custom_module_three" => "Custom Module 3",
		"custom_module_four" => "Custom Module 4",
		"custom_module_five" => "Custom Module 5"
	),
);

$sections = array();

$sections[] = array(
				'title' => __('General Settings',"TS"),
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_280_settings.png',
				'fields' => array(
					array(
						'id' => 'select_logo_tyle',
						'type' => 'select_hide_below',
						'title' => __('Select your custom background',"TS"), 
						'options' => array(
									'1' => array('name' => 'Use Site Title and tag line', 'allow' => 'true'),
									'2' => array('name' => 'Use your custom image', 'allow' => 'false')
									),//Must provide key => value(array) pairs for select options
						'std' => '1',
						'desc' => __('If you select "Using Title and tag line". Plz go to general on setting menu for custom title and tag line ',"TS"),
						'class'=>'selectparent',
					),
					
					array(
						'id' => 'select_logo_tyle_2',
						'type' => 'upload',
						'title' => __('Upload Your Logo',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Upload custom logo for your website',"TS")
						),
					array(
						'id' => 'use_fixed_width',
						'type' => 'checkbox',
						'title' => __('Enable Fixed with ',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('If you checked. Site will be display as fixed with',"TS"),
						'std'=>'0',
						),	
					array(
						'id' => 'enable_pattern_background_body',
						'type' => 'checkbox',
						'title' => __('Enable pattern background for body',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('If you checked. Site will be display as fixed with',"TS"),
						'std'=>'1',
						),	
						
					array(
						'id' => 'custom_favicon',
						'type' => 'upload',
						'title' => __('Upload Your Favicon',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Upload custom favicon for your website',"TS")
						),
					array(
						'id' => 'menu_level',
						'type' => 'text',
						'title' => __('Set level for menu',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Input a number',"TS"),
						'std'=>3,
						),
						
					array(
						'id' => 'enable_breadcrumbs',
						'type' => 'checkbox',
						'title' => __('Enable Breadcrumbs for your website',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Enable Breadcrumbs',"TS"),
						'std'=>'1',
						),
					array(
						'id' => 'enable_scroll_top',
						'type' => 'checkbox',
						'title' => __('Enable Scroll To Top',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Enable Scroll To Top',"TS"),
						'std'=>'1',
						),
					array(
						'id' => 'portfolio_list_url',
						'type' => 'text',
						'title' => __('Portfolio List Url',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Input a url',"TS"),
						'std'=>'Your Portfolio list link',
						),						
					array(
						'id' => 'tracking_code',
						'type' => 'textarea',
						'title' => __('Tracking Code',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Tracking code for your website',"TS")
						),

					)
				);
		
global $style_font_google;
global $style_font_standar;
global $style_font_size;
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_100_font.png',
				'title' => __('Font Settings',"TS"),
				'fields' => array(
					array(
						'id' => 'body_font_style',
						'type' => 'select_hide_below',
						'title' => __('<b style="color:red">Body</b> font style',"TS"), 
						'options'=> array(
							'1' => array('name' => 'Google Font', 'value' => 'Google Font','allow'=>'true'),
							'2' => array('name' => 'System Font', 'value' => 'System Font','allow'=>'true'),
						),
						'std' => '1',
						'class'=>'selectparent',
					),
					array(
						'id' => 'body_font_style_1',
						'type' => 'select',
						'title' => __('Choice a Google Font for body',"TS"), 
						'options'=>$style_font_google,
						'std' => 'Open Sans',
					),
					array(
						'id' => 'body_font_style_2',
						'type' => 'select',
						
						'title' => __('Choice a System Font',"TS"), 
						'options'=>$style_font_standar,
						'std' => 'Arial',
					),
					array(
						'id' => 'body_font_size',
						'type' => 'select',
						'title' => __('Body font style',"TS"), 
						'options'=> $style_font_size,
						'std' => '11',
					),
					
					array(
						'id' => 'menu_font_style',
						'type' => 'select_hide_below',
						'title' => __('<b style="color:red">Menu</b> font style',"TS"), 
						'options'=> array(
							'1' => array('name' => 'Google Font', 'value' => 'Google Font','allow'=>'true'),
							'2' => array('name' => 'System Font', 'value' => 'System Font','allow'=>'true'),
						),
						'std' => 'System Font',
						'class'=>'selectparent',
					),
					array(
						'id' => 'menu_font_style_1',
						'type' => 'select',
						'title' => __('Choice a Google Font for menu',"TS"), 
						'options'=>$style_font_google,
						'std' => 'Open Sans',
					),
					array(
						'id' => 'menu_font_style_2',
						'type' => 'select',
						'title' => __('Choice a System Font for menu',"TS"), 
						'options'=>$style_font_standar,
						'std' => 'Arial',
					),
					array(
						'id' => 'menu_font_size',
						'type' => 'select',
						'title' => __('menu font style',"TS"), 
						'options'=> $style_font_size,
						'std' => '13',
					),					
					array(
						'id' => 'heading_font_style',
						'type' => 'select_hide_below',
						'title' => __('<b style="color:red">Heading</b> font style',"TS"), 
						'options'=> array(
							'1' => array('name' => 'Google Font', 'value' => 'Google Font','allow'=>'true'),
							'2' => array('name' => 'System Font', 'value' => 'System Font','allow'=>'true'),
						),
						'std' => 'System Font',
						'class'=>'selectparent',
					),
					array(
						'id' => 'heading_font_style_1',
						'type' => 'select',
						'title' => __('Choice a Google Font for heading',"TS"), 
						'options'=>$style_font_google,
						'std' => 'Open Sans',
					),
					array(
						'id' => 'heading_font_style_2',
						'type' => 'select',
						'title' => __('Choice a System Font for heading',"TS"), 
						'options'=>$style_font_standar,
						'std' => 'Arial',
					),
					array(
						'id' => 'h1_font_size',
						'type' => 'select',
						'title' => __('H1 font size',"TS"), 
						'options'=> $style_font_size,
						'std' => '22',
					),						
					array(
						'id' => 'h2_font_size',
						'type' => 'select',
						'title' => __('H1 font size',"TS"), 
						'options'=> $style_font_size,
						'std' => '18',
					),						
					array(
						'id' => 'h3_font_size',
						'type' => 'select',
						'title' => __('H3 font size',"TS"), 
						'options'=> $style_font_size,
						'std' => '15',
					),						
					array(
						'id' => 'h4_font_size',
						'type' => 'select',
						'title' => __('H5 font size',"TS"), 
						'options'=> $style_font_size,
						'std' => '13',
					),											
					array(
						'id' => 'h5_font_size',
						'type' => 'select',
						'title' => __('H5 font size',"TS"), 
						'options'=> $style_font_size,
						'std' => '13',
					),						
					array(
						'id' => 'h6_font_size',
						'type' => 'select',
						'title' => __('H6 font size',"TS"), 
						'options'=> $style_font_size,
						'std' => '13',
					),						
					
					
								
				)
			);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_009_magic.png',
				'title' => __('Styling Settings',"TS"),
				'fields' => array(
					array(
						'id' => 'color_stream',
						'type' => 'color',
						'title' => __('Color Stream For Your Website',"TS"), 
						'std' => '#48CCCD'
						),		
					array(
						'id' => 'backgroundcolor',
						'type' => 'color',
						'title' => __('Background color :',"TS"), 
						'std' => '#ffffff'
						),								
					array(
						'id' => 'select_background',
						'type' => 'select_hide_below',
						'title' => __('Select your custom background image',"TS"), 
						'options' => array(
									'1' => array('name' => 'Use pre-defined background', 'allow' => 'true'),
									'2' => array('name' => 'Use your custom background', 'allow' => 'false')
									),//Must provide key => value(array) pairs for select options
						'std' => '1',
						'class'=>'selectparent',
						),																
					array(
						'id' => 'select_background_1',
						'type' => 'radio_img',
						'title' => __('Custom Background For Your Website',"TS"), 
						'options' => array(
										'36' => array('title' => '36', 'img' => NHP_OPTIONS_URL.'img/pattern/36.png'),
										'37' => array('title' => '37', 'img' => NHP_OPTIONS_URL.'img/pattern/37.png'),
										'38' => array('title' => '38', 'img' => NHP_OPTIONS_URL.'img/pattern/38.png'),
										'39' => array('title' => '39', 'img' => NHP_OPTIONS_URL.'img/pattern/39.png'),
										'40' => array('title' => '40', 'img' => NHP_OPTIONS_URL.'img/pattern/40.png'),
										'41' => array('title' => '41', 'img' => NHP_OPTIONS_URL.'img/pattern/41.png'),
										'42' => array('title' => '42', 'img' => NHP_OPTIONS_URL.'img/pattern/42.png'),
										'43' => array('title' => '43', 'img' => NHP_OPTIONS_URL.'img/pattern/43.png'),
										'44' => array('title' => '44', 'img' => NHP_OPTIONS_URL.'img/pattern/44.png'),
										'45' => array('title' => '45', 'img' => NHP_OPTIONS_URL.'img/pattern/45.png'),
										'46' => array('title' => '46', 'img' => NHP_OPTIONS_URL.'img/pattern/46.png'),
										'47' => array('title' => '47', 'img' => NHP_OPTIONS_URL.'img/pattern/47.png'),
										'48' => array('title' => '48', 'img' => NHP_OPTIONS_URL.'img/pattern/48.png'),
										'49' => array('title' => '49', 'img' => NHP_OPTIONS_URL.'img/pattern/49.png'),
										'50' => array('title' => '50', 'img' => NHP_OPTIONS_URL.'img/pattern/50.png'),
										'51' => array('title' => '51', 'img' => NHP_OPTIONS_URL.'img/pattern/51.png'),
										'52' => array('title' => '52', 'img' => NHP_OPTIONS_URL.'img/pattern/52.png'),
										'53' => array('title' => '53', 'img' => NHP_OPTIONS_URL.'img/pattern/53.png'),
										'54' => array('title' => '54', 'img' => NHP_OPTIONS_URL.'img/pattern/54.png'),
									
											),//Must provide key => value(array:title|img) pairs for radio options
						'std' => '36',
						
						),
					array(
						'id' => 'select_background_2',
						'type' => 'upload',
						'title' => __('Upload Your Custom Background',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Upload custom background for your website',"TS"),
						
						),
					array(
						'id' => 'custom_css',
						'type' => 'textarea',
						'title' => __('Custom Css',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Custom Css Code for your website. remember withaw <style></style>',"TS")
						),
						
					)
					);
					
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_020_home.png',
				'title' => __('Home Settings',"TS"),
				'fields' => array(
					array(
						'id' => 'select_slider_type',
						'type' => 'select_hide_belows',
						'title' => __('<b style="color:red">Select your slider</b>',"TS"), 
						'options' => array(
									'1' => array('name' => 'Static Banner', 'allow' => 'true'),
									'2' => array('name' => 'Nivo Slider', 'allow' => 'true'),
									'3' => array('name' => 'Static content + Slider', 'allow' => 'true'),
									'4' => array('name' => 'Layer Slider', 'allow' => 'true'),
									
									),//Must provide key => value(array) pairs for select options
						'std' => '1',
						'desc' => __(' ',"TS"),
						'class'=>'selectparents',
					),
					
					array(
						'id' => 'static_baner_textbox',
						'type' => 'editor',
						'title' => __('Content',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Insert Your Content',"TS"),
						'class' => 'select_slider_type_1',
						'std'=>' <h1><strong>Hiya, this is a page without slider!</strong></h1>
		                <p>Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus. Cras mattis cosi sectetut amet fermens etrsaters dimets.</p>',
						),			
					array(
						'id' => 'layer_slider_select_slider',
						'type' => 'layer_slider_select',
						'title' => __('Select a slider for Layer  slider',"TS"), 
						'sub_desc' => __('',"TS"),
						'class' => 'select_slider_type_4',
						),							
					array(
						'id' => 'enable_submit_form',
						'type' => 'checkbox_hide_belows',
						'title' => __('Enable Submit Form',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('If you check, submit form will display',"TS"),
						'std' =>'1',
						'class' => 'select_slider_type_1',
						),		
					array(
						'id' => 'enable_submit_form_email',
						'type' => 'text',
						'title' => __('Email Received :',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Email will receive  the email of client',"TS"),
						'std' =>get_option('admin_email'),
						'class' => 'enable_submit_form select_slider_type_1',
						),		
					array(
						'id' => 'static_baner_image',
						'type' => 'upload',
						'title' => __('Upload Image',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Upload Image Banner. Best size : 518px × 373px',"TS"),
						'class' => 'select_slider_type_1',
						'std'=>NHP_OPTIONS_URL.'img/default/responsive.png',
						),	
					array(
						'id' => 'static_slider_textbox',
						'type' => 'editor',
						'title' => __('Content',"TS"), 
						'sub_desc' => __('',"TS"),
						'desc' => __('Insert Your Content',"TS"),
						'class' => 'select_slider_type_3',
						'std'=>'<h1>Hello! <strong>This is a version with small slider</strong></h1>
		                <p>Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus. Cras mattis cosi sectetut amet fermens etrsaters dimets.</p>
		                <p class="button-container"><span><a href="#" class="button button-big">Get Started</a></span></p>',
						),			
						
					array(
						'id' => 'static_slider_select_slider',
						'type' => 'sliders_select',
						'title' => __('Select a slider for static content + slider',"TS"), 
						'sub_desc' => __('',"TS"),
						'args'=>array(
						'post_type'=>'slider'
						),
						'class' => 'select_slider_type_3',
						),	
						
					array(
						'id' => 'nivo_slider_select_slider',
						'type' => 'sliders_select',
						'title' => __('Select a slider for Nivo',"TS"), 
						'sub_desc' => __('',"TS"),
						'args'=>array(
						'post_type'=>'slider'
						),
						'class' => 'select_slider_type_2',
						'std'=>'',
						),
						
						
					array(
						'id' => 'nivo_slider_effect',
						'type' => 'select',
						'title' => __('Nivo Slider effect',"TS"), 
						'sub_desc' => __('',"TS"),
						'std'=>'random',
						'options'=> array(
							        
							'sliceDown'=> 'sliceDown',
							'sliceDownLeft'=>'sliceDownLeft',
							'sliceUp'=>'sliceUp',
							'sliceUpLeft'=>'sliceUpLeft',
							'sliceUpDown'=>'sliceUpDown',
							'sliceUpDownLeft'=>'sliceUpDownLeft',
							'fold'=>'fold',
							'fade'=>'fade',
							'random'=>'random',
							'slideInRight'=>'slideInRight',
							'slideInLeft'=>'slideInLeft',
							'boxRandom'=>'boxRandom',
							'boxRain'=>'boxRain',
							'boxRainReverse'=>'boxRainReverse',
							'boxRainGrow'=>'boxRainGrow',
							'boxRainGrowReverse'=>'boxRainGrowReverse',

						),
						'desc' => __('Choice a effect. Default is Random',"TS"),
						'class' => 'select_slider_type_2',
						),				
					array(
						'id' => 'nivo_slider_slices',
						'type' => 'text',
						'title' => __('Nivo Slider slices',"TS"), 
						'sub_desc' => __('',"TS"),
						'std'=>'15',
						'class' => 'select_slider_type_2',
						),
					array(
						'id' => 'nivo_slider_speed',
						'type' => 'text',
						'title' => __('Nivo Slider Speed',"TS"), 
						'sub_desc' => __('',"TS"),
						'std'=>'5000',
						'class' => 'select_slider_type_2',
						),
					array(
						'id' => 'nivo_slider_pause_speed',
						'type' => 'text',
						'title' => __('Nivo Slider Pause time',"TS"), 
						'sub_desc' => __('',"TS"),
						'std'=>'3000',
						'class' => 'select_slider_type_2',
						),
					array(
						'id' => 'nivo_slider_directionNav',
						'type' => 'checkbox',
						'title' => __('Next & Prev navigation',"TS"), 
						
						'sub_desc' => __('',"TS"),
						'std'=>'1',
						'class' => 'select_slider_type_2',
						),
					array(
						'id' => 'nivo_slider_pauseOnHover',
						'type' => 'checkbox',
						
						'title' => __('Stop animation while hovering',"TS"), 
						'sub_desc' => __('',"TS"),
						'std'=>'1',
						'class' => 'select_slider_type_2',
						),
					array(
						'id' => 'home_page_title',
						'type' => 'editor',
						'title' => __('Top Home Title',"TS"), 
						'sub_desc' => __('',"TS"),
						'std'=>'<h1>Welcome to LittleSquare clean and responsive PSD template.<br>We set new standards in user experience and make future happen.</h1>',
						),
											
					array(
						'id' => 'home_pages',
						'type' => 'pages_select',
						'args'=>array(
						
						),
						'title' => __('<b style="color:red">Select a page for home page.</b>',"TS"),
						'std' => '1',
						),
					)	
				);
/*
Get sidebar
*/
global $theme_option;
$theme_option = get_option("themestudio");
$blog_cat_sidebar =$theme_option["sidebar"];
global $default_sidebar1;
if($blog_cat_sidebar != null){
$blog_cat_sidebar = array_merge($blog_cat_sidebar,$default_sidebar1);
}else
{
$blog_cat_sidebar = $default_sidebar1;
}
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_318_more-items.png',
				'title' => __('Blog Settings',"TS"),
				'fields' => array(
					array(
						'id' => 'blog_readmore',
						'type' => 'text',
						'title' => __('Enter your Readmore text',"TS"), 
						'std' => 'Read More &rarr;',
						),
					array(
						'id' => 'blog_except_lenght',
						'type' => 'text',
						'title' => __('Blog except lenght',"TS"), 
						'std' => '50',
						'validate'=>'numeric',
						),
						
					array(
						'id' => 'blog_meta_enable',
						'type' => 'multi_select',
						'title' => __('Blog Meta Enable',"TS"), 
						'std' => array(
									'time'=>'time',
									'author'=>'author',
									'categories'=>'categories',
									'tags'=>'tags',
									'comments'=>'comments',
									),//Must provide key => value(array) pairs for select options,
						'options'=>array(
									'time'=>'time',
									'author'=>'author',
									'categories'=>'categories',
									'tags'=>'tags',
									'comments'=>'comments',
									),//Must provide key => value(array) pairs for select options,
						),

					array(
						'id' => 'blog_category_layout_1',
						'type' => 'radio_img',
						'title' => __('Category,Archived layout',"TS"), 
						'options' => array(
										'1' => array('title' => 'Left Sidebar', 'img' => NHP_OPTIONS_URL.'img/1column.png'),
										'2' => array('title' => 'Right Sidebar', 'img' => NHP_OPTIONS_URL.'img/2columns.png'),
											),//Must provide key => value(array:title|img) pairs for radio options
						'std' => '2'
						),
					array(
						'id' => 'blog_category_nums',
						'type' => 'text',
						'title' => __('nums of Blog category,Archived  dislay',"TS"), 
						'std' => '10',
						'validate'=>'numeric',
						),						
					array(
						'id' => 'blog_category_sidebar',
						'type' => 'select',
						'title' => __('Category,Archived Sidebar',"TS"), 
						'options' => $blog_cat_sidebar,
						'std' => 'Blog Sidebar'
						),
					array(
						'id' => 'blog_single_layout_1',
						'type' => 'radio_img',
						'title' => __('Blog Single layout',"TS"), 
						'options' => array(
										'1' => array('title' => 'Left Sidebar', 'img' => NHP_OPTIONS_URL.'img/1column.png'),
										'2' => array('title' => 'Right Sidebar', 'img' => NHP_OPTIONS_URL.'img/2columns.png'),
											),//Must provide key => value(array:title|img) pairs for radio options
						'std' => '2'
						),
					array(
						'id' => 'blog_single_sidebar',
						'type' => 'select',
						'title' => __('Blog Single Sidebar',"TS"), 
						'options' => $blog_cat_sidebar,
						'std' => 'Blog Sidebar'
						
						),	
					array(
						'id' => 'comment_message',
						'type' => 'textarea',
						'title' => __('Comment Text Message',"TS"),
						'desc' => __('This text will display inside the comment message box as pleace holder.',"TS"),
						'std' => 'Write your comment here.'
						),				
					array(
						'id' => 'enable_comment_post',
						'type' => 'checkbox',
						'title' => __('Enable comment in single post page',"TS"),
						'std' => '1',
						),									
					),
					
				);
/*				
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_309_comments.png',
				'title' => __('Comment Settings',"TS"),
				'fields' => array(					
					array(
						'id' => 'comment_message',
						'type' => 'textarea',
						'title' => __('Comment Text Message',"TS"),
						'desc' => __('This text will display inside the comment message box as pleace holder.',"TS"),
						'std' => 'Write your comment here.'
						),				
					array(
						'id' => 'enable_comment_post',
						'type' => 'checkbox',
						'title' => __('Enable comment in single post page',"TS"),
						'std' => 1
						),			
					array(
						'id' => 'enable_comment_page',
						'type' => 'checkbox',
						'title' => __('Enable comment in single page page',"TS"),
						'std' => 1
						),			
					array(
						'id' => 'enable_comment_portfolio',
						'type' => 'checkbox',
						'title' => __('Enable comment in single portfolio page',"TS"),
						'std' => 1
						),			
					)
				);
*/
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_153_more_windows.png',
				'title' => __('Sidebar Settings',"TS"),
				'desc' => __('<p class="description">Sidebar Settings</p>',"TS"),
				'fields' => array(					
					array(
						'id' => 'sidebar',
						'type' => 'multi_text',
						'title' => __('Sidebar',"TS"),
						'desc' => __('This is the description field, again good for additional info.',"TS"),
						'std' => $sidebar
						),
					),
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_154_show_big_thumbnails.png',
				'title' => __('Footer Settings',"TS"),
				'fields' => array(	
					array(
						'id' => 'enable_footer_widget',
						'type' => 'checkbox_hide_below',
						'title' => __('Enable Footer Widget',"TS"), 
						'sub_desc' => __('If you enable,you can using widget on footer',"TS"),
						'desc' => __('If you enable,you can using widget on footer',"TS"),
						'std'=>'1',
						),				
					array(
						'id' => 'footer_widgets',
						'type' => 'select',
						'title' => __('Number Column Widget In Footer',"TS"),
						'options' => array('1'=>'One Column','2'=>'Two Columns','3'=>'Three Columns','4'=>'Four Columns'),
						'std' => '4'
						),
					array(
						'id' => 'copyright_text',
						'type' => 'textarea',
						'title' => __('Copyright Text',"TS"), 
						'sub_desc' => __('Can also use the validation methods if required',"TS"),
						'desc' => __('This is the description field, again good for additional info.',"TS"),
						'std' => 'Copyright @ThemeStudio.Net.'
						),
					
						
					)
				);	
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_023_cogwheels.png',
				'title' => __('Advanced Settings',"TS"),
				'fields' => array(					
					array(
						'id' => 'custom_backend_logo',
						'type' => 'upload',
						'title' => __('Custom backend branding logo',"TS"),
						),
					array(
						'id' => 'custom_theme_name',
						'type' => 'text',
						'title' => __('Custom Theme Name',"TS"), 
						'std' => TS_THEME_NAME
						)
					)
				);				
	$tabs = array();
			
	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$theme_uri = $theme_data->get('ThemeURI');
		$description = $theme_data->get('Description');
		$author = $theme_data->get('Author');
		$version = $theme_data->get('Version');
		$tags = $theme_data->get('Tags');
	}else{
		$theme_data = wp_get_theme();
		$theme_uri = $theme_data['URI'];
		$description = $theme_data['Description'];
		$author = $theme_data['Author'];
		$version = $theme_data['Version'];
		$tags = $theme_data['Tags'];
	}	

	$theme_info = '<div class="ts-options-section-desc">';
	$theme_info .= '<p class="ts-options-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ',"TS").'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="ts-options-theme-data description theme-author">'.__('<strong>Author:</strong> ',"TS").$author.'</p>';
	$theme_info .= '<p class="ts-options-theme-data description theme-version">'.__('<strong>Version:</strong> ',"TS").$version.'</p>';
	$theme_info .= '<p class="ts-options-theme-data description theme-description">'.$description.'</p>';
	$theme_info .= '<p class="ts-options-theme-data description theme-tags">'.__('<strong>Tags:</strong> ',"TS").implode(', ', $tags).'</p>';
	$theme_info .= '</div>';



	$tabs['theme_info'] = array(
					'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_195_circle_info.png',
					'title' => __('Theme Information',"TS"),
					'content' => $theme_info
					);
	
	if(file_exists(trailingslashit(get_stylesheet_directory()).'README.html')){
		$tabs['theme_docs'] = array(
						'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_071_book.png',
						'title' => __('Documentation',"TS"),
						'content' => nl2br(file_get_contents(trailingslashit(get_stylesheet_directory()).'README.html'))
						);
	}//if

	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);
	

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function
?>