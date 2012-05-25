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

/**
 * Don't edit this file directly, instead, create a local-config.php file and add your database
 * settings and defines in there. This file contains the production settings
 */
if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {

	include( dirname( __FILE__ ) . '/wp-config-local.php' );

	define( 'HM_DEV', true );

} else {

	// ** MySQL settings - You can get this info from your web host ** //
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'hm-base' );

	/** MySQL database username */
	define( 'DB_USER', 'root' );

	/** MySQL database password */
	define( 'DB_PASSWORD', 'root' );

	/** MySQL hostname */
	define( 'DB_HOST', 'localhost' );

	/** Database Charset to use in creating database tables. */
	define( 'DB_CHARSET', 'utf8' );

	/** The Database Collate type. Don't change this if in doubt. */
	define( 'DB_COLLATE', '' );
	
}

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-r3^3v=w!ea]0C<WuftKn79Vm{B_>vNb*y+4u1hc] `J&MBX|d,{B(q>|qq0|N[?' );
define( 'SECURE_AUTH_KEY',  '(^@;J`kSJ|l6l|,HtP3^W`ACdWbBj[ugC)7:mK#S>Iq`WGVUaF*;zVS~TRI$r(_K' );
define( 'LOGGED_IN_KEY',    'U,<+%6L/X>pJf4t`S{9[2UJ,&W5_n`t4;Y8+nMv}:h@>,bcU7ea:<{7e+}+`C+$E' );
define( 'NONCE_KEY',        'gH>,RJ;d H3?]d}T$`N-32Y:W.+BBKpI8i%A++;<`&`Lr26IaKx&NJo+wWt91}B,' );
define( 'AUTH_SALT',        '=5skQDkX}]f1LL+am7e4Z-!$<`P#?)33jL@fy.(QJ IlGKBAc~}cf_M.=K&}{^F7' );
define( 'SECURE_AUTH_SALT', '?Yx`jPtR{-[)3`W&Z}%X~rUfv+-K{Rj$>gWt[ZY{:.mdr`MP?@++H<yRZUYQ-4du' );
define( 'LOGGED_IN_SALT',   '9,xpWU@DLj+k}#b>p9kVIGjgFW%jyb%qcn&%$192r]BzR06~b=D2s!WigqstK*MX' );
define( 'NONCE_SALT',       '(Pg?dqz6^xC@+uE9]$lH|OO2mxpH1|9?:<BF*td61eP#7X>[ AgZQ?Lk?D|-nIz+' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define( 'WPLANG', '' );

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if ( ! defined( 'WP_DEBUG' ) )
	define( 'WP_DEBUG', false );
	
if ( ! defined( 'WP_SITEURL' ) )
	define( 'WP_SITEURL', $_SERVER['HTTP_HOST'] . '/wordpress/' );

if ( ! defined( 'WP_HOME' ) )
	define( 'WP_HOME', $_SERVER['HTTP_HOST'] );

define( 'WP_CONTENT_DIR', dirname( __FILE__ ) );
define( 'WP_CONTENT_URL', WP_HOME );

define( 'WP_DEFAULT_THEME', 'Twenty Twelve' ); 

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname(__FILE__) . '/' );

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );