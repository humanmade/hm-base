<?php
namespace HM\Gutenberg_Blocks\Blocks;

use const HM\Gutenberg_Blocks\ROOT_DIR;

function bootstrap() {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\block_loader', 100 );
}

// TODO - maybe some kind of autoloading?
function block_loader() {
	$blocks_dir = ROOT_DIR . '/src/blocks';

	require_once $blocks_dir . '/hmn-example/index.php';
	\HM\Gutenberg_Blocks\HmnExample\bootstrap();
}
