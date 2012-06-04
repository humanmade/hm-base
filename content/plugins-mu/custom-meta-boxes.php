<?php

/*
Plugin Name: Custom Metaboxes and Fields
Description: This will create metaboxes with custom fields that will blow your mind.
Author: Andrew Norcross, Jared Atchison, Bill Erickson
Author URI: https://github.com/humanmade/Custom-Meta-Boxes
*/

if( ! file_exists( WPMU_PLUGIN_DIR . '/custom-meta-boxes/init.php' ) )
	die( 'Custom Metaboxes and Fields plugin not found. If this is not required, delete <code>' . __FILE__ );

// Load Custom Metaboxes and Fields for WordPress
function hm_initialize_cmb_meta_boxes() {
	include_once(   WPMU_PLUGIN_DIR . '/custom-meta-boxes/init.php' );
}
add_action( 'init', 'hm_initialize_cmb_meta_boxes', 9999 );
