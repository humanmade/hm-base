<?php
namespace HM\Gutenberg_Blocks\Blocks;

use const HM\Gutenberg_Blocks\ROOT_DIR;
use HM\Gutenberg_Blocks\Helpers as Helpers;

function bootstrap() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\block_loader', 100 );
}

// TODO - maybe some kind of autoloading?
function block_loader() {
	// Add support for the example block for demonstration purposes.
	add_filter( 'hm_blocks', function( $blocks ) {
		return array_merge( $blocks, [ 'hmn/example' ] );
	} );

	$blocks_dir       = ROOT_DIR . '/src/blocks';
	$supported_blocks = Helpers\get_supported_blocks();

	if ( in_array( 'hmn/example', $supported_blocks, true ) ) {
		require_once $blocks_dir . '/hmn-example/index.php';
		\HM\Gutenberg_Blocks\HmnExample\bootstrap();
	}
}
