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

// sane default for wp-cli etc
if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
	$_SERVER['HTTP_HOST'] = '';
}

/**
 * Don't edit this file directly, instead, create a local-config.php file and add your database
 * settings and defines in there. This file contains the production settings
 */
if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {
	include( dirname( __FILE__ ) . '/wp-config-local.php' );

	defined( 'HM_DEV' ) or define( 'HM_DEV', true );
	defined( 'WP_DEBUG' ) or define( 'WP_DEBUG', true );
	defined( 'SAVEQUERIES' ) or define( 'SAVEQUERIES', true );

} elseif ( file_exists( '/var/cloudformation-vars.php' ) ) {

	defined( 'HM_DEV' ) or define( 'HM_DEV', false );

	include( '/var/cloudformation-vars.php' );
} elseif ( file_exists( dirname( __FILE__ ) . '/wp-config-production.php' ) ) {
	defined( 'HM_DEV' ) or define( 'HM_DEV', false );
	include( dirname( __FILE__ ) . '/wp-config-production.php' );
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
define( 'AUTH_KEY',         '%dy32y+}-B6CbY?L^`G^7V%m7_X-{H|pQFT.o<!zFy #KJH|i)g!Gmv.l.RNG=FH' );
define( 'SECURE_AUTH_KEY',  'bq-0xSuVmYU$,DpNcIF(w_wXA~QFLy}neMX4pfx}/WE5q;]d?L%I&/HTU}nhZ;aZ' );
define( 'LOGGED_IN_KEY',    'XE3>+dW}|%9-R)}|5)%8MB7Fw`3(&A%J`{TGO>[{c<5!|OC3@2,s|I_&Fa)S1VZc' );
define( 'NONCE_KEY',        ';>@VI/uXi:h-2[|p|Y;5Q:1B!MEtw+jo]oTCpZ8Y@|7wj2HFjr]k$cc7{@Ip>}4j' );
define( 'AUTH_SALT',        'e85rP5Nv #Uvr!Q!~zTdoXu .GDWm_9~ Y*-FT:UCq+T;CN<4{=f8AiJ6EN22|Ji' );
define( 'SECURE_AUTH_SALT', 'PN=A.~g|EPg$2G7u/Z<v.)5|Cul|4-v%82,*@fTRj<+XOz(~.![cq$f+Z]/(|]m%' );
define( 'LOGGED_IN_SALT',   '=E)%I:|oC| jV}@C&~@`n~jcm]_/ef-j][Btr0m%8%M|E:=G`|?|~Z[c:jSaomT}' );
define( 'NONCE_SALT',       'zn0$xcc DX|6HYI0!gh`IdT5+xfX6cA5T;>-Tz,Q}h[Dw6*.U>6)h(w,o5fad+[|' );

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

define( 'DB_CHARSET', 'utf8' );

// Define Site URL: WordPress in a subdirectory.
if ( ! defined( 'WP_SITEURL' ) ) {
	define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress' );
}

// Define Home URL
if ( ! defined( 'WP_HOME' ) ) {
	define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
}

// Define path & url for Content
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', WP_HOME . '/content' );

// Set path to MU Plugins.
define( 'WPMU_PLUGIN_DIR', dirname( __FILE__ ) . '/content/plugins-mu' );
define( 'WPMU_PLUGIN_URL', WP_HOME . '/content/plugins-mu' );

// Prevent editing of files through the admin.
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );

if ( ! defined( 'HM_DEV') || ! HM_DEV ) {
	defined( 'WP_CACHE' ) or define( 'WP_CACHE', true );
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
