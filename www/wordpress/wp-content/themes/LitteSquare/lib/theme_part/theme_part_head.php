<?php
/*
* ----------------------------------------------------------------------------------------------------
* Block of header
* @PACKAGE BY TT from Themestudio.net
* Author : Vthanh
* ----------------------------------------------------------------------------------------------------
*/

#
#Load Style
#
global $theme_options;
function  TT_load_styles() 
{	
	//Load Bootstrap
	wp_register_style('bootstrap-min', THEMESTUDIO_CSS.'/bootstrap.min.css', false, THEME_VERSION, 'screen');
	wp_enqueue_style('bootstrap-min');
		
	//Load Flex SLider	
	wp_register_style('flexslider', THEMESTUDIO_CSS.'/flexslider.css', false, THEME_VERSION, 'screen');
	wp_enqueue_style('flexslider');
		
	//Load Nivo Slider
	wp_register_style('nivo-slider', THEMESTUDIO_CSS.'/nivo-slider.css', false, THEME_VERSION, 'screen');
	wp_enqueue_style('nivo-slider');
		
	//Load DA Slider
	wp_register_style('da-slider', THEMESTUDIO_CSS.'/da-slider.css', false, THEME_VERSION, 'screen');
	wp_enqueue_style('da-slider');
		
	//Load Main Style	
	wp_register_style('style', THEMESTUDIO_CSS.'/style.css', false, THEME_VERSION, 'screen');
	wp_enqueue_style('style');

}
add_action("wp_print_styles", 'TT_load_styles');
#
# JavaSrcipts For The Front
#
function  TT_load_scripts() 
{	
	if(!is_admin())
	{
		wp_enqueue_script('jquery');
		
		// Jquery bootstrap.min
		wp_register_script( 'bootstrap.min', THEMESTUDIO_JS. '/bootstrap.min.js', false, THEME_VERSION );
		wp_enqueue_script('bootstrap.min');
		
		// Jquery modernizr
		wp_register_script( 'modernizr.custom.js', THEMESTUDIO_JS. '/modernizr.custom.js', false, THEME_VERSION );
		wp_enqueue_script('modernizr.custom.js');
		
		// Jquery superfish menu
		wp_register_script( 'superfish.js', THEMESTUDIO_JS. '/superfish.js', false, THEME_VERSION );
		wp_enqueue_script('superfish.js');
		
		// Jquery mobile menu
		wp_register_script( 'jquery.mobilemenu.js', THEMESTUDIO_JS. '/jquery.mobilemenu.js', false, THEME_VERSION );
		wp_enqueue_script('jquery.mobilemenu.js');
		
		// Jquery Nivo Slider
		wp_register_script( 'jquery.nivo.slider.pack.js', THEMESTUDIO_JS. '/jquerynivoslider.js', false, THEME_VERSION );
		global $theme_options;
		if($theme_options["select_slider_type"] == "2" || (isset($_GET["sl"]) && ($_GET["sl"]== 2))):
			wp_enqueue_script('jquery.nivo.slider.pack.js');
		endif;
		// Jquery Flex Slider
		wp_register_script( 'jquery.flexslider-min.js', THEMESTUDIO_JS. '/jquery.flexslider-min.js', false, THEME_VERSION );
		//wp_enqueue_script('jquery.flexslider-min.js');
		
		// Jquery cslide
		wp_register_script( 'jquery.cslider.js', THEMESTUDIO_JS. '/jquery.cslider.js', false, THEME_VERSION );
		//wp_enqueue_script('jquery.cslider.js');
		
		// Jquery Grey Scale
		wp_register_script( 'greyScale.min.js', THEMESTUDIO_JS. '/greyScale.min.js', false, THEME_VERSION );
		//wp_enqueue_script('greyScale.min.js');
		
		// Jquery Tweet Jquery
		wp_register_script( 'jquery.tweet.js', THEMESTUDIO_JS. '/jquery.tweet.js', false, THEME_VERSION );
		
		// Prety Photo
		wp_register_script( 'jquery.tweet.js', THEMESTUDIO_JS. '/jquery.tweet.js', false, THEME_VERSION );
		
		//wp_enqueue_script('jquery.tweet.js');
		
		// Jquery superfish menu
		wp_register_script( 'main.js', THEMESTUDIO_JS. '/main.js', false, THEME_VERSION );
		wp_enqueue_script('main.js');
		
		
	}
}
add_action('wp_print_scripts', 'TT_load_scripts');

function tt_other_meta_load()
{
echo '
<meta charset="utf-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114.png" />
';

}
add_action('wp_head', 'tt_other_meta_load');
#
# Add favicon icon
#
function tt_load_favicon_icon() 
{
	global $theme_options;
	$favicon = $theme_options["custom_favicon"];
	if ($favicon) { echo '<link rel="shortcut icon" href="'.$favicon.'" />',"\n"; }
}
add_action('wp_head', 'tt_load_favicon_icon');
#
# JavaSrcipts For IE
#
function tt_load_ie_srcipts() 
{
	echo ''."\n";
	echo '<!--[if lt IE 9]>'."\n";
	echo '<script type="text/javascript" src="'.THEMESTUDIO_JS.'/ie.min.js?ver='.THEME_VERSION.'"></script>'."\n";
	echo '<![endif]-->'."\n";
}

add_action('wp_head', 'tt_load_ie_srcipts');
//IE 9 fix
function IE9_fix()
{
echo '<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->';
};
add_action('wp_head','IE9_fix');
// <IE7 Warring
function IE7_warring()
{
echo '<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->';
};
// Add script
/*
Custome style for theme




*/
add_action('wp_head','IE7_warring');

function load_color(){
/* Load Custom Style */
if(isset($_GET["cl"]) || isset($_SESSION["color"])){

if(isset($_GET["cl"]))
{
$color = $_GET["cl"];
$_SESSION["color"] = $color;
}elseif(isset($_SESSION["color"])){
$color = $_SESSION["color"];
}

echo "<link rel='stylesheet' id='ts-custom-css'  href='".THEMESTUDIO_CSS."/color/".$color.".css' type='text/css' media='screen' />";

}
}

add_action('wp_head','theme_custome_style');
add_action('wp_head','load_color');

function theme_custome_style()
{
global $theme_options;
$return = "";
$font_body="";
$font_menu="";
$font_heading="";

// Menu
$menu_size=$theme_options["menu_font_size"];;
//Body
$body_size=$theme_options["body_font_size"];
// Heading
$h1_size=$theme_options["h1_font_size"];;
$h2_size=$theme_options["h2_font_size"];;
$h3_size=$theme_options["h3_font_size"];;
$h4_size=$theme_options["h4_font_size"];;
$h5_size=$theme_options["h5_font_size"];;
$h6_size=$theme_options["h6_font_size"];;


$font_body_style=$theme_options["body_font_style"];
if($font_body_style == "1"):
	$font_body = $theme_options["body_font_style_1"];
	$return.='<link  media="screen" type="text/css" href="http://fonts.googleapis.com/css?family='.str_replace(' ','+',$font_body).':300,400,700" rel="stylesheet">'."\n";
endif;
$font_heading_style=$theme_options["heading_font_style"];
if($font_heading_style == "1"):
	$font_heading = $theme_options["heading_font_style_1"];
	$return.='<link  media="screen" type="text/css" href="http://fonts.googleapis.com/css?family='.str_replace(' ','+',$font_heading).':300,400,700" rel="stylesheet">'."\n";
endif;
$font_menu_style=$theme_options["menu_font_style"];
if($font_menu_style == "1"):
	$font_menu = $theme_options["menu_font_style_1"];
	$return.='<link  media="screen" type="text/css" href="http://fonts.googleapis.com/css?family='.str_replace(' ','+',$font_menu).':300,400,700" rel="stylesheet">'."\n";
endif;
$custom_css = $theme_options["custom_css"];

$return.="<style>";


//set fixed with
	if(isset($theme_options["use_fixed_width"]) && $theme_options["use_fixed_width"]=="1"){
		$return.="body{max-width:1004px;margin:20px auto;} #home-top-content .button-container span,.slider-nivo #header,#home-top-content{background:#fff !important; }header,#header {
    background: url('".THEMESTUDIO_IMG."/dotted.png') repeat-x bottom  #fff }";
	}
	if(!isset($theme_options["use_fixed_width"]) && isset($theme_options["enable_pattern_background_body"]) &&  $theme_options["enable_pattern_background_body"]=="1"){
	
	$return.="body.ts_style3 #body,body.ts_style3 #breadcrumbs{max-width:1004px}";
	}
	$return.=get_color_main($theme_options["color_stream"]);
	$bg1 ='37';
	if(isset($theme_options["select_background_1"]))
	{
	$bg1 =$theme_options["select_background_1"];
	}
	$bg2 ='';
	if(isset($theme_options["select_background_2"]))
	{
	$bg2 =$theme_options["select_background_2"];
	}
	
	// Custom background
	if($theme_options["select_background"] == "1"){
		$return.='body{ background:url('.NHP_OPTIONS_URL.'img/pattern/'.$bg1.'.png) '.$theme_options["backgroundcolor"].'}';
	}else{
	$return.='body{ background:url('.$bg2.') '.$theme_options["backgroundcolor"].'}';
	}
	// Custom Font- Color
	$font_body = $theme_options["body_font_style_1"];
	$font_heading = $theme_options["heading_font_style_1"];
	$font_menu = $theme_options["menu_font_style_1"];
	$return.='
	body{ 
	font-size:'.$body_size.'px;
	font-family:"'.$font_body.'","Helvetica Neue",Helvetica,"Arial";
	}
	#header-title h1, #header-title h2{ font-family:"Helvetica Neue",Helvetica,"'.$font_body.'",Arial;}
	h1,h2,h3,h4,h5,h6{
	font-family:"Helvetica Neue",Helvetica,"'.$font_heading.'",Arial,"sans-serif";	
	}
	h1{
		font-size:'.$h1_size.'px;
	}
	h2{
		font-size:'.$h2_size.'px;
	}
	h3{
		font-size:'.$h3_size.'px;
	}
	h4{
		font-size:'.$h4_size.'px;
	}
	h5{
		font-size:'.$h5_size.'px;
	}
	h6{
		font-size:'.$h6_size.'px;
	}
	#header-navigation, #breadcrumbs, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input, .select-menu, #copyright, #pagination, .font-circle, #portfolio-container dd, #filter, .tabs-left > .nav-tabs > li > a, .tabs-right > .nav-tabs > li > a{
	font-size:'.$body_size.'px;
	font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
	}
	';
	
$return.=$custom_css;	
$return.="</style>";
echo $return;
}
/*
Get Color Main
Author : Themecenter
*/
function get_color_main($color){
$color1 = substr ($color,1);
$return='#header, #header-navigation nav > ul > li > a, #header-navigation ul ul, #header-navigation ul ul li:first-child a:hover, #header-navigation ul ul > li.current-menu-item:first-child a, #filter a:hover, #filter a.active, textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-input:focus, .sc-staff .thumbnail:hover, blockquote, #home-top-content input[type="text"]:focus, #home-top-content textarea:focus{ border-color:'.$color.'}';
$return.='#header-navigation em, #header-title h2, #page-404 strong, #filter a:hover, #filter a.active, #pagination strong, #comments .author a, .widget_archives a:hover, .tabs-left > .nav-tabs .active > a, .tabs-left > .nav-tabs .active > a:hover, .tabs-right > .nav-tabs .active > a, .tabs-right > .nav-tabs .active > a:hover{ color:'.$color.'}';
$return.='#portfolio-container .c2 dd,.flexslider:hover .flex-next:hover, .flexslider:hover .flex-prev:hover,#header-navigation ul ul > li.current-menu-item a, #header-navigation ul ul a:hover, #header-navigation ul ul > li.current-menu-item a, .nivo-directionNav .nivo-nextNav:hover, .nivo-directionNav .nivo-prevNav:hover, .da-arrows span:hover, #portfolio-container dd, #copyright, .first, .pricing-table, .accordion-heading .accordion-toggle span, .highlight,#portfolio-container .c3 dd{background-color:'.$color.'}';
$return.='.wpb_tour .ui-tabs .ui-tabs-nav li.ui-tabs-active a,.wpb_tour .ui-tabs .ui-tabs-nav li:hover a,a{color:'.$color.'}';
$return.='a:hover{color:#'.hex_lighter($color1,20).'}';
$return.='.sequence_wrap .controls li.prev:hover{background:url('.THEMESTUDIO_IMG.'/direct-nav-big.png) #'.$color1.'}
			.sequence_wrap .controls li.next:hover{background:url('.THEMESTUDIO_IMG.'/direct-nav-big.png) -42px 0 #'.$color1.'}
			.sequence_wrap .wpbslider-inner h2{color:#'.$color1.'}
			
			.pricing-table h2{border-bottom:1px solid #'.hex_darker($color1,23).';}
			.price {
				background: none repeat scroll 0 0 #'.hex_lighter($color1,20).';
				text-shadow: 1px 0 0 #'.hex_darker($color1,10).';
			}
			.sidebar .widget a:hover{ color:#'.$color1.'; }
			.wpb_content_element .ui-state-default .ui-icon, .wpb_content_element .ui-state-active .ui-icon{background-color:'.$color.'}
			.sign-up .button{box-shadow: 0 0 1px #'.hex_lighter($color1,10).'}
';

$return.='.flex-control-paging li a.flex-active,
.flex-control-paging li a:hover,
input[type="submit"], button, .button, .button-big,
input[type="submit"]:hover, button:hover, .button:hover, .button-big:hover {
	
	background: -moz-linear-gradient(to bottom, #'.hex_lighter($color1,10).' 0%, #'.hex_lighter($color1,20).' 100%);
    background: -webkit-gradient(to bottom, #'.hex_lighter($color1,10).' 0%, #'.hex_lighter($color1,20).' 100%);
    background: -webkit-linear-gradient(top, #'.hex_lighter($color1,10).' 0%, #'.hex_lighter($color1,20).' 100%);
	background: -o-linear-gradient(to bottom, #'.hex_lighter($color1,10).' 0%, #'.hex_lighter($color1,20).' 100%);
    background: linear-gradient(to bottom, #'.hex_lighter($color1,10).' 0%, #'.hex_lighter($color1,20).' 100%);
    background: -ms-linear-gradient(to bottom, #'.hex_lighter($color1,10).' 0%, #'.hex_lighter($color1,20).' 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#'.hex_lighter($color1,10).', endColorstr='.hex_lighter($color1,20).',GradientType=0 ); /* IE6-9 */
	
	border-color: #'.hex_lighter($color1,20).' #'.hex_lighter($color1,15).' #'.hex_darker($color1,23).';
    box-shadow: 0 0 0 1px #'.hex_lighter($color1,43).' inset, 0 1px 1px 0 #D9D9D9;
    color: #'.hex_darker($color1,60).';
    text-shadow: 0 1px 0 #'.hex_lighter($color1,60).';
}
input[type="submit"]:hover, button:hover, .button:hover, .button-big:hover {
	/* invert for hover effect (replace colors) */
	background: -moz-linear-gradient(top, #'.hex_lighter($color1,20).' 0%, #'.hex_lighter($color1,10).' 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#'.hex_lighter($color1,20).'), color-stop(100%,#'.hex_lighter($color1,10).')); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #'.hex_lighter($color1,20).' 0%,#'.hex_lighter($color1,10).' 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #'.hex_lighter($color1,20).' 0%,#'.hex_lighter($color1,10).' 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #'.hex_lighter($color1,20).' 0%,#'.hex_lighter($color1,10).' 100%); /* IE10+ */
	background: linear-gradient(to bottom, #'.hex_lighter($color1,20).' 0%,#'.hex_lighter($color1,10).' 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#'.hex_lighter($color1,20).'", endColorstr="#'.hex_lighter($color1,10).'",GradientType=0 ); /* IE6-9 */
}

/* the same main color, but in RGBA format ([72, 204, 205], 0.7) - change value in [] 
:hover > .overlay {
    background: none repeat scroll 0 0 rgba(72, 204, 205, 0.7);
}
*/
*:hover > .overlay { background: rgba('.hex2RGB($color1,'true').',0.7); }
#filter a:hover, #filter a.active {
	-moz-box-shadow: 1px 1px 1px #'.hex_lighter($color1,10).';
	-webkit-box-shadow: 1px 1px 1px #'.hex_lighter($color1,10).';
	box-shadow: 1px 1px 1px #'.hex_lighter($color1,10).';
}
textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-input:focus, #home-top-content input[type="text"]:focus, #home-top-content textarea:focus {
	-moz-box-shadow: 0 0 8px #'.hex_lighter($color1,10).';
	-webkit-box-shadow: 0 0 8px #'.hex_lighter($color1,10).';
	box-shadow: 0 0 8px  #'.hex_lighter($color1,10).';
}
.ls-nav-prev:hover{ background-color: #'.$color1.' !important;}
.ls-nav-next:hover{ background-color: #'.$color1.' !important;}
.ls-container  h2{ color : #'.$color1.'}
.ls_heading_bg_color{ background:#'.$color1.' !important;}
';
$return .='#filter a:hover, #filter a.active{box-shadow:#'.hex_lighter($color1,60).'}';
return $return;
}
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}
/* 
Add Tracking Code
Author : Themecenter
*/
function add_tracking_code()
{
   if(get_theme_option('general','Google_analytics_Code') != '')
   {
   echo '<div>'.stripslashes($theme_options["tracking_code"]).'</div>';
   }
}
add_action('wp_footer','add_tracking_code');
?>