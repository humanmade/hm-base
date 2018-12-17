<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package hm-base
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL;
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Disable update checks for core, themes, and plugins.
 *
 * No need for this work to happen when spinning up tests.
 */
tests_add_filter( 'muplugins_loaded', function() {
	remove_action( 'wp_maybe_auto_update', 'wp_maybe_auto_update' );
	remove_action( 'wp_update_themes', 'wp_update_themes' );
	remove_action( 'wp_update_plugins', 'wp_update_plugins' );

	remove_action( 'admin_init', '_maybe_update_core' );
	remove_action( 'admin_init', 'wp_maybe_auto_update' );
	remove_action( 'admin_init', 'wp_auto_update_core' );
	remove_action( 'admin_init', '_maybe_update_themes' );
	remove_action( 'admin_init', '_maybe_update_plugins' );

	remove_action( 'wp_version_check', 'wp_version_check' );
} );

/**
 * Re-map the default `/uploads` folder with our own `/test-uploads` for tests.
 *
 * WordPress core runs a method (scan_user_uploads) on the first instance of
 * `WP_UnitTestCase`. This method scans every single folder and file in the
 * uploads directory.
 *
 * This filter prevents any potential issues arising from running imports
 * locally and speeds up overall test execution. We do this by adding a unique
 * test uploads folder just for our tests to reduce load.
 */
tests_add_filter( 'upload_dir', function( $dir ) {
	array_walk( $dir, function( &$item ) {
		if ( is_string( $item ) ) {
			$item = str_replace( '/uploads', '/test-uploads', $item );
		}
	} );
	return $dir;
}, 20 ); // Ensure this fires late, after other filtering has occurred.

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
