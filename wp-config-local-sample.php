<?php
/**
 * Local WordPress configuration setup.
 */

/**
 * Modify database credentials for your local machine.
 */
define( 'DB_NAME', 'database_name_here' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );

/**
 * Ensure that WP paths are appropriately routed.
 */
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress' );
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );

/**
 * No point in running auto updates on local.
 */
defined( 'AUTOMATIC_UPDATER_DISABLED' ) or define( 'AUTOMATIC_UPDATER_DISABLED', true );

/**
 * Ensure that errors are visible and logged.
 */
defined( 'WP_DEBUG' ) or define( 'WP_DEBUG', true );
defined( 'WP_DEBUG_LOG' ) or define( 'WP_DEBUG_LOG', true );
defined( 'WP_DEBUG_DISPLAY' ) or define( 'WP_DEBUG_DISPLAY', true );

/**
 * Force scripts into dev mode.
 */
defined( 'SCRIPT_DEBUG' ) or define( 'SCRIPT_DEBUG', true );
