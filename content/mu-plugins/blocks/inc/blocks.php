<?php
namespace HM\Gutenberg_Blocks\Blocks;

use Exception;
use function HM\Gutenberg_Blocks\Helpers\get_supported_blocks;
use const HM\Gutenberg_Blocks\ROOT_DIR;

function bootstrap() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\block_loader', 100 );
}

// TODO - maybe some kind of autoloading?
function get_available_blocks() {
	$blocks_dir = ROOT_DIR . '/src/blocks';
	$supported_blocks = get_supported_blocks();

	if ( in_array( 'hmn/example', $supported_blocks, true ) ) {
		require_once $blocks_dir . '/example/index.php';
		Example\bootstrap();
	}
}
