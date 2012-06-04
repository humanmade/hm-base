<?php

/*
Plugin Name: WP Thumb
Plugin URI: https://github.com/humanmade/WPThumb
Description: An on-demand image generation replacement for WordPress' image resizing.
Author: Human Made Limited
Author URI: http://www.hmn.md/
*/

if ( ! file_exists( WPMU_PLUGIN_DIR . '/wpthumb/wpthumb.php' ) )
	die( 'WP Thumb plugin not found. If this is not required, delete <code>' . __FILE__ );

// Load WPThumb unless it's specifically disabled or already included elsewhere
if ( ( ! defined( 'HM_ENABLE_PHPTHUMB' ) || HM_ENABLE_PHPTHUMB ) && ! function_exists( 'wpthumb' ) )
    require_once ( WPMU_PLUGIN_DIR . '/wpthumb/wpthumb.php' );


