<?php

	/*
	Plugin Name: HM Dev
	Description: Code like a poet
	Author: Human Made Limited
	Author URI: http://hmn.md/
	*/

	if ( ! file_exists( WPMU_PLUGIN_DIR . '/hm-dev/hm-dev.plugin.php' ) )
		die( 'HM Dev plugin not found. If this is not required, delete <code>' . __FILE__ );

	if ( defined( 'HM_DEV' ) && HM_DEV )
		require_once ( WPMU_PLUGIN_DIR . '/hm-dev/hm-dev.plugin.php' );