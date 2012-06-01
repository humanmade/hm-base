<?php

	/*
	Plugin Name: TLC Transients
	Description: A WordPress transients interface with support for soft-expiration (use old content until new content is available), background updating of the transients (without having to wait for a cron job), and a chainable syntax that allows for one liners.
	Author: Mark Jaquith
	Author URI: https://github.com/markjaquith/WP-TLC-Transients.git
	*/

	if ( ! file_exists(  WPMU_PLUGIN_DIR . '/tlc-transients/tlc-transients.php' ) )
		die( 'TLC Transient plugin not found. If this is not required, delete <code>' . __FILE__ );

	add_action( 'init', function() {

		if ( current_theme_supports( 'tlc-transients' ) )
			require_once (  WPMU_PLUGIN_DIR . '/tlc-transients/tlc-transients.php' );

	} );

