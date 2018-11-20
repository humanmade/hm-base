<?php
/**
 * Detecting and load scripts from a theme or plugin `asset-manifest.json` file, to enable PHP to detect and load from
 * the  WebpackDevServer whenever that server is active.
 *
 * If no asset manifest is detected the `enqueue_webpack_dev_server_assets()` function will return `false`, permitting
 * theme and plugin code to manually handle their own enqueues while the development server is not running.
 *
 * Built off of https://github.com/humanmade/react-wp-scripts.
 *
 * @package HM_Asset_Loader
 */

namespace HM\Asset_Loader;

/**
 * Register a single script.
 *
 * Automatically handles loading dev/build versions.
 *
 * @param array $args Script args.
 * @param string $build_dir Build directory.
 * @return void
 */
function register_script( $args ) {
	$args = wp_parse_args( $args, [
		'deps'      => [],
		'version'   => get_asset_version(),
		'in_footer' => false,
		'build_dir' => false,
	] );

	wp_register_script(
		$args['handle'],
		get_asset_uri_by_name( $args['name'], $args['build_dir'] ),
		$args['deps'],
		$args['version'],
		$args['in_footer']
	);
}

/**
 * Register and enqueue a single script.
 *
 * Automatically handles loading dev/build versions.
 *
 * @param array $args Script args.
 * @param string $build_dir Build directory.
 * @return void
 */
function enqueue_script( $args ) {
	register_script( $args );
	wp_enqueue_script( $args['handle'] );
}

/**
 * Register a single script.
 *
 * Automatically handles loading dev/build versions.
 *
 * @param array $args Script args.
 * @param string $build_dir Build directory.
 * @return void
 */
function register_style( $args ) {
	$args = wp_parse_args( $args, [
		'deps'    => [],
		'version' => get_asset_version(),
	] );

	$uri    = get_asset_uri_by_name( $args['name'], $args['build_dir'], 'css' );
	$is_dev = pathinfo( $uri, PATHINFO_EXTENSION ) === 'js';

	// Register style. Don't worry that we're trying to en
	wp_register_style(
		$args['handle'],
		$uri,
		$args['deps'],
		$args['version']
	);

	// In development, we need to load the style JS file whenever the style CSS is loaded.
	if ( $is_dev ) {
		add_action( 'style_loader_tag', function( $tag, $handle ) use ( $args, $uri ) {
			if ( $handle === $args['handle'] ) {
				$tag = sprintf( '<script src="%s"></script>', esc_url( $uri ) );
			}
			return $tag;
		}, 10, 2 );
	}
}

/**
 * Register and enqueue a single style.
 *
 * Automatically handles loading dev/build versions.
 *
 * @param array $args Script args.
 * @param string $build_dir Build directory.
 * @return void
 */
function enqueue_style( $args ) {
	register_style( $args );
	wp_enqueue_style( $args['handle'] );
}

/**
 * Helper function to find the asset URI.
 *
 * - If dev, returns the dev asset.
 * - Else returns the URL to the file in the build directory.
 *
 * @param string $asset_name Name of asset used in webpack config.
 * @param string $build_dir Build dir path. Assumes that asset manifest file is found here.
 * @return string Asset source URI.
 */
function get_asset_uri_by_name( $asset_name, $build_dir, $ext = 'js' ) {
	$asset_list = get_webpack_dev_server_assets_list( $build_dir );

	// If is development, find the file URI by name.
	if ( $asset_list ) {
		$matches = array_values( array_filter( $asset_list, function( $asset ) use ( $asset_name ) {
			return $asset_name === pathinfo( $asset, PATHINFO_FILENAME );
		} ) );

		return ! empty( $matches ) ? get_asset_path_or_uri( $matches[0], '' ) : '';
	} else {
		$base = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $build_dir );
		return sprintf( '%s/%s.%s', $base, $asset_name, $ext );
	}
}

/**
 * Check a directory for a dev server asset manifest file, and attempt to decode and return the asset list JSON if
 * found.
 *
 * @param string $directory Root directory possibly containing an `asset-manifest.json` file.
 * @return array|null Array of assets on success, else null.
 */
function get_webpack_dev_server_assets_list( string $directory ) {
	$dev_assets = load_asset_file( trailingslashit( $directory ) . 'asset-manifest.json' );

	if ( empty( $dev_assets ) ) {
		return null;
	}

	return array_values( $dev_assets );
}

/**
 * Get a cache-busting version of assets for CSS & JS used on HM's servers.
 *
 * @returns string|null String if hash file is needed and found.
 */
function get_asset_version() {
	if ( ! defined( 'HM_DEPLOYMENT_REVISION' ) ) {
		return null;
	}

	return HM_DEPLOYMENT_REVISION;
}

/**
 * Attempt to load a file at the specified path and parse its contents as JSON.
 *
 * @param string $path The path to the JSON file to load.
 * @return array|null; Array of data on success, else null.
 */
function load_asset_file( $path ) {
	if ( ! file_exists( $path ) ) {
		return null;
	}

	$contents = file_get_contents( $path );

	if ( empty( $contents ) ) {
		return null;
	}

	return json_decode( $contents, true );
}

/**
 * Return web URIs or convert relative filesystem paths to absolute paths.
 *
 * @param string $asset_path A relative filesystem path or full resource URI.
 * @param string $base_url   A base URL to prepend to relative bundle URIs.
 * @return string Absolute path or URI to asset.
 */
function get_asset_path_or_uri( string $asset_path, string $base_url ) {
	if ( strpos( $asset_path, '://' ) !== false ) {
		return $asset_path;
	}

	return trailingslashit( $base_url ) . $asset_path;
}
