<?php

/**
 * LudicrousDB configuration file
 *
 * This file should be installed at ABSPATH/db-config.php
 *
 * $wpdb is an instance of the LudicrousDB class which extends the wpdb class.
 *
 * See readme.txt for documentation.
 */

$wpdb->save_queries = false;
$wpdb->persistent = false;
$wpdb->max_connections = 10;
$wpdb->check_tcp_responsiveness = true;

$wpdb->add_database(array(
	'host'     => DB_HOST,     // If port is other than 3306, use host:port.
	'user'     => DB_USER,
	'password' => DB_PASSWORD,
	'name'     => DB_NAME,
));

/**
 * This adds the same server again, only this time it is configured as a slave.
 * The last three parameters are set to the defaults but are shown for clarity.
 */
if ( defined( 'DB_HOST_SLAVE' ) && DB_HOST_SLAVE ) {
	$wpdb->add_database(array(
		'host'     => DB_HOST_SLAVE,     // If port is other than 3306, use host:port.
		'user'     => DB_USER,
		'password' => DB_PASSWORD,
		'name'     => DB_NAME,
		'write'    => 0,
		'read'     => 1,
		'dataset'  => 'global',
		'timeout'  => 0.2,
	));
}

