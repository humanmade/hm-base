<?php
/**
 * Installs WordPress for running the tests and loads WordPress and the test libraries
 */


$config_file_path = dirname( dirname( dirname( __FILE__ ) ) );
if ( ! file_exists( $config_file_path . '/wp-tests-config.php' ) ) {
	// Support the config file from the root of the develop repository.
	if ( basename( $config_file_path ) === 'phpunit' && basename( dirname( $config_file_path ) ) === 'tests' )
		$config_file_path = dirname( dirname( $config_file_path ) );
}
$config_file_path .= '/wp-tests-config.php';

/*
 * Globalize some WordPress variables, because PHPUnit loads this file inside a function
 * See: https://github.com/sebastianbergmann/phpunit/issues/325
 */
global $wpdb, $current_site, $current_blog, $wp_rewrite, $shortcode_tags, $wp, $phpmailer;

if ( !is_readable( $config_file_path ) ) {
	die( "ERROR: wp-tests-config.php is missing! Please use wp-tests-config-sample.php to create a config file.\n" );
}
require_once $config_file_path;

define( 'WP_TESTS_TABLE_PREFIX', $table_prefix );
define( 'DIR_TESTDATA', dirname( __FILE__ ) . '/../data' );

if ( ! defined( 'WP_TESTS_FORCE_KNOWN_BUGS' ) )
	define( 'WP_TESTS_FORCE_KNOWN_BUGS', false );

// Cron tries to make an HTTP request to the blog, which always fails, because tests are run in CLI mode only
define( 'DISABLE_WP_CRON', true );

$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['HTTP_HOST'] = WP_TESTS_DOMAIN;
$PHP_SELF = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

if ( "1" == getenv( 'WP_MULTISITE' ) ||
	( defined( 'WP_TESTS_MULTISITE') && WP_TESTS_MULTISITE ) ) {
	$multisite = true;
} else {
	$multisite = false;
}

// Override the PHPMailer
require_once( dirname( __FILE__ ) . '/mock-mailer.php' );
$phpmailer = new MockPHPMailer();

system( WP_PHP_BINARY . ' ' . escapeshellarg( dirname( __FILE__ ) . '/install.php' ) . ' ' . escapeshellarg( $config_file_path ) . ' ' . $multisite );

if ( $multisite ) {
	echo "Running as multisite..." . PHP_EOL;
	define( 'MULTISITE', true );
	define( 'SUBDOMAIN_INSTALL', false );
	$GLOBALS['base'] = '/';
} else {
	echo "Running as single site... To run multisite, use -c tests/phpunit/multisite.xml" . PHP_EOL;
}
unset( $multisite );

require_once dirname( __FILE__ ) . '/functions.php';

$GLOBALS['_wp_die_disabled'] = false;
// Allow tests to override wp_die
tests_add_filter( 'wp_die_handler', '_wp_die_handler_filter' );

// Preset WordPress options defined in bootstrap file.
// Used to activate themes, plugins, as well as  other settings.
if(isset($GLOBALS['wp_tests_options'])) {
	function wp_tests_options( $value ) {
		$key = substr( current_filter(), strlen( 'pre_option_' ) );
		return $GLOBALS['wp_tests_options'][$key];
	}

	foreach ( array_keys( $GLOBALS['wp_tests_options'] ) as $key ) {
		tests_add_filter( 'pre_option_'.$key, 'wp_tests_options' );
	}
}

// Load WordPress
require_once ABSPATH . '/wp-settings.php';

// Delete any default posts & related data
_delete_all_posts();

require dirname( __FILE__ ) . '/testcase.php';
require dirname( __FILE__ ) . '/testcase-xmlrpc.php';
require dirname( __FILE__ ) . '/testcase-ajax.php';
require dirname( __FILE__ ) . '/testcase-canonical.php';
require dirname( __FILE__ ) . '/exceptions.php';
require dirname( __FILE__ ) . '/utils.php';

