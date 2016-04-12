<?php

if ( class_exists( 'Memcached' ) ) {
	require_once __DIR__ . '/plugins-mu/memcached-object-cache-pecl/object-cache.php';
} else {
	require_once __DIR__ . '/plugins-mu/memcached-object-cache/object-cache.php';
}
