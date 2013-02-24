<?php
/**
 * Required by WordPress.
 *
 * Keep this file clean and only use it for requires.
 */


$themedata = $get_theme = wp_get_theme();
get_template_part('nhp', 'options');
define('TS_THEME_NAME', $get_theme);
define('THEME_VERSION', '1.0.0');

define('THEMESTUDIO_BASE_URL', get_template_directory_uri());
define('THEMESTUDIO_BASE_DIR', get_template_directory());

// Theme Langguage
define('LANG',THEMESTUDIO_BASE_DIR.'/lang');
load_theme_textdomain( 'TS', LANG);

define('THEMESTUDIO_BASE', get_template_directory());
define('THEMESTUDIO_PATH', THEMESTUDIO_BASE . '/lib');
define('THEMESTUDIO_LOOP', THEMESTUDIO_BASE . '/loop/');

define('THEMESTUDIO_PATH_WIDGET', THEMESTUDIO_BASE . '/lib/widgets/');
define('THEMESTUDIO_THEME_PART', THEMESTUDIO_BASE . '/lib/theme_part/');
define('THEMESTUDIO_THEME_FUNCTIONS', THEMESTUDIO_BASE . '/lib/functions/');

define('THEMESTUDIO_THEME_OPTION', THEMESTUDIO_PATH . '/theme-options');
define('THEMESTUDIO_URL', THEMESTUDIO_BASE_URL . '/lib');
define('THEMESTUDIO_THEME_OPTION_URL', THEMESTUDIO_URL . '/theme-options');
define('THEMESTUDIO_JS', THEMESTUDIO_BASE_URL . '/js');
define('THEMESTUDIO_CSS', THEMESTUDIO_BASE_URL . '/css');
define('THEMESTUDIO_IMG', THEMESTUDIO_BASE_URL . '/img');
define('THEMESTUDIO_TEMPLATE', THEMESTUDIO_BASE_URL . '/templates/');

//Load Meta For Theme
require_once ('lib/ts_registers.php');

// Load Function Help
require_once ('lib/functions.php');
//Load Frameworks Functions
require_once locate_template('/lib/framework.php');          // Custom functions
//Load Widget
require_once locate_template('/lib/widgets.php');          // Custom functions
//Load Part Of Theme
require_once locate_template('/lib/theme_part.php');          // Custom functions
require_once locate_template('/lib/widgets_sidebar.php');          // Custom functions

//Load js slider 
//require_once ('lib/wpb_sequencer/index.php');

//Load Functions
//path to directory to scan

//get all image files with a .jpg extension.
$theme_loops = glob(THEMESTUDIO_LOOP . "*.php");
//print each file name
foreach($theme_loops as $theme_loop)
{
require_once($theme_loop);

}
 // Load Visual Composer
 
 
 
global $wpVC_setup;
global $composer_settings;
require_once('js_composer/js_composer.php');
$wpVC_setup->init($composer_settings);

//require_once('lib/wpb_sequencer/index.php');
?>