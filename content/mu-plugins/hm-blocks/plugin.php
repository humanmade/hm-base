<?php
/**
 * Plugin Name: HM Blocks
 *
 * @package HM
 */

namespace HM\Gutenberg_Blocks;

// We use this constant to enqueue development assets, which is more flexible than relative paths.
const ROOT_DIR = __DIR__;

// Load helpers first, so that other code can rely on them.
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/assets.php';
require_once __DIR__ . '/inc/blocks.php';

// Bootstrap the helpers.
Assets\bootstrap();
Blocks\bootstrap();
