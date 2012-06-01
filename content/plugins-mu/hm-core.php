<?php

	/*
	Plugin Name: HM Core
	Description: A set of helpful frameworks, functions, classes.
	Author: Human Made Limited
	Author URI: http://hmn.md/
	*/

	if ( ! file_exists( WPMU_PLUGIN_DIR . '/hm-core/hm-core.plugin.php' ) )
		die( 'HM Core plugin not found. If this is not required, delete <code>' . __FILE__ );

	if ( ! function_exists( 'hm' ) )
		require_once ( WPMU_PLUGIN_DIR . '/hm-core/hm-core.plugin.php' );