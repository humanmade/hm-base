<?php
/**
 * Hero Block.
 *
 * @package HM
 */

namespace HM\Gutenberg_Blocks\HmnExample;

/**
 * Set up hooks.
 */
function bootstrap() {
	add_action( 'init', __NAMESPACE__ . '\\register_block' );
}

/**
 * Register the block.
 */
function register_block() {
	$options = [
		'attributes' => [
			'heading' => [
				'type' => 'string',
			],
			'subHeading' => [
				'type' => 'string',
			],
		],
		'render_callback' => __NAMESPACE__ . '\\render_block',

	];

	register_block_type(
		'hmn/example',
		$options
	);
}

/**
 * Render the block on the front end.
 *
 * @param array $attributes Array of attributes extracted from the block markup.
 *
 * @return string Block HTML
 */
function render_block( $attributes = [] ) {
	ob_start();

	echo wp_json_encode( $attributes );

	return ob_get_clean();
}
