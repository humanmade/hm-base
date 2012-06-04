<?php

/*
Plugin Name: HM Accounts
Description:
Author: Human Made Limited
Author URI: http://hmn.md/
*/

if ( ! file_exists( WPMU_PLUGIN_DIR . '/hm-accounts.php' ) )
	die( 'HM Accounts plugin not found. If this is not required, delete <code>' . __FILE__ );

// Only load HM Accounts if it's enabled
if ( defined( 'HM_ENABLE_ACCOUNTS' ) && HM_ENABLE_ACCOUNTS !== false )
	include_once( HM_CORE_PATH . 'hm-accounts/hm-accounts.php' );
