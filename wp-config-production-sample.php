<?php

$table_prefix  = getenv('TABLE_PREFIX') ?: 'wp_';

foreach ($_ENV as $key => $value) {
    $capitalized = strtoupper($key);
    if (!defined($capitalized)) {
        define($capitalized, $value);
    }
}
global $memcached_servers;
$memcached_servers = array( array( MEMCACHED_HOST, MEMCACHED_PORT ) );

global $redis_server;
$redis_server = array(
	'host' => REDIS_HOST,
	'port' => REDIS_PORT,
);


if( defined('DISPLAY_ERRORS') && DISPLAY_ERRORS ) {
    error_reporting(E_ALL);
    @ini_set('display_errors', 1);
}
