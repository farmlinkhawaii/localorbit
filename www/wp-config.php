<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
if(strpos($_SERVER['HTTP_HOST'],'dev') !== false)
{
	define('DB_NAME', 'localorb_wp_dev');
	define('DB_USER', 'localorb_www');
	define('DB_PASSWORD', 'localorb_www_dev');
	define('DB_HOST', 'localhost');
}
else if(strpos($_SERVER['HTTP_HOST'],'newui') !== false)
{
	define('DB_NAME', 'localorb_wp_newui');
	define('DB_USER', 'localorb_www');
	define('DB_PASSWORD', 'l0cal1sdab3st');
	define('DB_HOST', 'localorb.cc2ndox9watl.us-west-2.rds.amazonaws.com');
}
else if(strpos($_SERVER['HTTP_HOST'],'qa') !== false)
{
	define('DB_NAME', 'localorb_wp_qa');
	define('DB_USER', 'localorb_www');
	define('DB_PASSWORD', 'l0cal1sdab3st');
	define('DB_HOST', 'localorb.cc2ndox9watl.us-west-2.rds.amazonaws.com');
}
else if(strpos($_SERVER['HTTP_HOST'],'testing') !== false)
{
	define('DB_NAME', 'localorb_wp_testing');
	define('DB_USER', 'localorb_www');
	define('DB_PASSWORD', 'l0cal1sdab3st');
	define('DB_HOST', 'localorb.cc2ndox9watl.us-west-2.rds.amazonaws.com');
}
else
{
	define('DB_NAME', 'localorb_wp_production');
	define('DB_USER', 'localorb_www');
	define('DB_PASSWORD', 'l0cal1sdab3st');
	define('DB_HOST', 'localorb.cc2ndox9watl.us-west-2.rds.amazonaws.com');
}

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'uE23e3~qUr$~- GBXL#/6}/,9pj+s{0iDMP7?##mrL*.rCbd,]C6Q[$:>R4]k6|?');
define('SECURE_AUTH_KEY',  'B{[Fb|jX>c 0zn)wyv4y`d,xXnh8wD1ns,l>jl7ZGj.R8e1FP d,{B?8Ip|u+yQD');
define('LOGGED_IN_KEY',    '|=E|F$9e:NC[U}nbtRsT(xvnrs8N~uzqL3v7w[DwYLp3uw+j_-LudH^Gw*5+QUD+');
define('NONCE_KEY',        '1,[cizc#dLpDP=TgrE>pptj]Fd|qh95y~5^3BV30&p~w-|s{r 3URwu5#V|TalN5');
define('AUTH_SALT',        'ynDy2T{SDek-B-`y--|@Km.BS>Nwx5..c^6[:}1M1Di5=-+e;JE]Eg|3-wh=<Th!');
define('SECURE_AUTH_SALT', 'S#g `]RN:$cxJzWjnB^LXi-]m~Wy-^nT&aU.<ae?iF[Fo3]R= oL3LOJU~|fujVc');
define('LOGGED_IN_SALT',   'bFUsJ`jv<.mwpV2Y_~Ilfyc3|aYb/-DFT/liT6=O{B @YZB m!I)+JHa.l}&|a|G');
define('NONCE_SALT',       '%g-|cptGEGP}7b@@6P;pp%4d]!!6R:RoV~x~JFSW$blBsHFbydHe@wV31%4x+/h&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'lo_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
