<?php

$table_prefix  = getenv('TABLE_PREFIX') ?: 'wp_';

foreach ($_ENV as $key => $value) {
    $capitalized = strtoupper($key);
    if (!defined($capitalized)) {
        define($capitalized, $value);
    }
}

if( defined('DISPLAY_ERRORS') && DISPLAY_ERRORS ) {
    error_reporting(E_ALL);
    @ini_set('display_errors', 1);
}
