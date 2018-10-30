<?php
/**
 * Handle asset enqueuing in development and build mode.
 *
 * @package HM
 */

namespace HM\Gutenberg_Blocks\Assets;

use const HM\Gutenberg_Blocks\ROOT_DIR;
use function HM\Gutenberg_Blocks\Helpers\get_supported_blocks;
use HM\Asset_Loader;

/**
 * Add hooks.
 */
function bootstrap() {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets', 1 );
}

/**
 * Enqueue the block JS and CSS assets depending on the current asset building mode.
 */
function enqueue_assets() {
	// Find out whether we are in development or build mode.
	$is_dev_mode = Asset_Loader\get_webpack_dev_server_assets_list( ROOT_DIR );

	if ( $is_dev_mode ) {
		// Enqueue the development assets from the Webpack dev server.
		Asset_Loader\enqueue_webpack_dev_server_assets(
			ROOT_DIR,
			[
				'handle'  => 'hm-gb-blocks-dev',
				'scripts' => [ 'wp-blocks', 'wp-element', 'wp-url', 'wp-components', 'wp-editor' ],
			]
		);

		// Attach JS dependencies to the Core editor script.
		$handle = 'wp-editor';
	} else {
		// Enqueue the build versions of the block JS and CSS.
		wp_enqueue_script(
			'hm-gb-blocks',
			plugins_url( '/build/index.js', dirname( __FILE__ ) ),
			[ 'wp-blocks', 'wp-element', 'wp-url', 'wp-components', 'wp-editor' ],
			Asset_Loader\get_asset_version(),
			true
		);

		wp_enqueue_style(
			'hm-gb-blocks',
			plugins_url( '/build/style.css', dirname( __FILE__ ) ),
			[],
			Asset_Loader\get_asset_version()
		);

		// Attach JS dependencies to the main blocks file.
		$handle = 'hm-gb-blocks';
	}

	// Deregister the block library theme styles.
	// This cannot easily be dequeued or deregistered as it is a dependency of other styles.
	// Work around this by registering a new style with a blank src.
	// The styles from this file have been copied into the base theme editor.scss (and modified).
	wp_deregister_style( 'wp-block-library-theme' );
	wp_register_style( 'wp-block-library-theme', '' );

	// Output an object with the blocks supported by the current theme.
	wp_localize_script( $handle, 'HMCurrentThemeBlockSupport', get_supported_blocks() );
}

function enqueue_block_editor_assets() {
	/**
	 * Filter function to select only blocks whose names include the word "editor".
	 */
	$editor_blocks_only = function( $script_key ) {
		return strpos( $script_key, 'editor' ) !== false;
	};

	$plugin_path  = plugin_dir_path( dirname( __FILE__ ) );
	$plugin_url   = plugin_dir_url( dirname( __FILE__ ) );
	$dev_manifest = $plugin_path . 'build/asset-manifest.json';

	$loaded_dev_assets = Asset_Loader\enqueue_assets( $dev_manifest, [
		'handle'    => 'artefact-editor-blocks',
		'filter'    => $editor_blocks_only,
		'scripts'   => [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
	] );

	if ( ! $loaded_dev_assets ) {
		// Production mode. Manually enqueue script bundles.
		wp_enqueue_script(
			'artefact-editor-blocks',
			$plugin_url . 'build/editor.bundle.js',
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
			filemtime( $plugin_path . '/build/editor.bundle.js' ),
			true
		);

		wp_enqueue_style(
			'artefact-editor-blocks',
			$plugin_url . 'build/editor.bundle.css',
			null,
			filemtime( $plugin_path . 'build/editor-bundle.css' )
		);
	}

	register_i18n_textdomain();
}
