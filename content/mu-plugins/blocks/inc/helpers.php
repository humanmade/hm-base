<?php
/**
 * Helper functions
 */

namespace HM\Gutenberg_Blocks\Helpers;

/**
 * Hackish solution to distinguish between block renders on the front end, and the back end.
 *
 * In the admin, the global `$wp_query` does not contain a query. We use this to determine whether a rendering is
 * happening on the front end or the back end.
 *
 * @return bool Whether we're in the admin or on the front end.
 */
function is_front_end_query() {
	return ! is_null( $GLOBALS['wp_query']->query );
}

/**
 * Get Red Bull Media Hub blocks that are currently enabled.
 *
 * Can also be filtered using the filter `hm_blocks`.
 *
 * @return array Array of block names.
 */
function get_supported_blocks() {
	$theme_support = get_theme_support( 'hm-blocks' );
	return apply_filters( 'hm_blocks', isset( $theme_support[0] ) ? $theme_support[0] : [] );
}
