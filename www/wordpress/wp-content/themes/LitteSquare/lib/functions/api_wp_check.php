<?php
/*
* ----------------------------------------------------------------------------------------------------
* Theme Check
* @PACKAGE BY HAWKTHEME
* ----------------------------------------------------------------------------------------------------
*/



/*
* Wordpress Check Message
*/
function theme_check_message()
{	
	global $wp_version;
	$errors = array();
	if(!theme_check_wp_version()){
		$errors[]='Wordpress version('.$wp_version.') is too low. Please upgrade to 3.1 and above.';
	}
	if(!function_exists("gd_info")){
		$errors[]='GD library has not compiled with its version of PHP.';
	}
	
	$str = '';
	if(!empty($errors)){
		$str = '<div class="error">';
		foreach($errors as $error){
			$str .= '<p>'.$error.'</p>';
		}
		$str .= '</div>';
	}
	return $str;
}




/*
* Check Whether the current wordpress version is support for the theme.
*/
function theme_check_wp_version()
{
	global $wp_version;	
	$check_WP   = '3.1';
	$is_ok  =  version_compare($wp_version, $check_WP, '>=');	
	if ( ($is_ok == FALSE) ) {
		return false;
	}	
	return true;
}


?>