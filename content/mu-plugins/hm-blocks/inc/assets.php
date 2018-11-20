<?php
/**
 * Handle asset enqueuing in development and build mode.
 *
 * @package HM
 */

namespace HM\Gutenberg_Blocks\Assets;

use const HM\Gutenberg_Blocks\ROOT_DIR;
use HM\Gutenberg_Blocks\Helpers as Helpers;
use HM\Asset_Loader;

/**
 * Add hooks.
 */
function bootstrap() {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_editor_assets', 1 );
}

/**
 * Enqueue the block JS and CSS assets.
 */
function enqueue_editor_assets() {
	Asset_Loader\enqueue_script([
		'name' => 'editor',
		'handle' => 'hm-blocks-editor',
		'deps' => [ 'wp-blocks', 'wp-element', 'wp-url', 'wp-components', 'wp-editor' ],
		'build_dir' => ROOT_DIR . '/build',
	] );

	Asset_Loader\enqueue_style([
		'name' => 'style',
		'handle' => 'hm-blocks-editor',
		'build_dir' => ROOT_DIR . '/build',
	] );
}
