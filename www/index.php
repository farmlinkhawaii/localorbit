<?php
if(in_array(strtolower($_SERVER['HTTP_HOST']),array('localorbit.com','localorbit.it','localorbit.org','www.localorbit.com','www.localorbit.org')))
{
	header('Location: http://www.localorb.it/');
	exit();
}

$prtcl = ($_SERVER['SERVER_PORT'] == 80)?'http://':'https://';

if(isset($_REQUEST['_escaped_fragment_']))
{
	define('__CORE_AJAX_OUTPUT__',false);
	include('app/index.php');
	exit();
}

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require('./wordpress/wp-blog-header.php');
