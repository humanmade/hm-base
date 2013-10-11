<?php

/**
 *
 * Add file last modified time to version param of of enqueued scripts & styles
 * 
 * This automagically busts cache whenever there is a change in a file.
 */

add_action( 'wp_enqueue_scripts', function() {

    global $wp_styles, $wp_scripts;

    // Find path of site root. Accounts for WP in subdir.
    $site_root_path = str_replace( str_replace( home_url(), '', site_url() ), '', ABSPATH );

    foreach ( array( 'wp_styles', 'wp_scripts' ) as $resource ) {

        foreach ( (array) $$resource->queue as $name ) {

            $registered_resource = $$resource->registered[$name];

            // Skip external and admin assets.
            if ( false === strpos( $registered_resource->src, home_url() ) )
                continue;

            $file = str_replace( home_url( '/' ), $site_root_path, $registered_resource->src );
            $mtime = filectime( $file );
            $$resource->registered[$name]->ver = $$resource->registered[$name]->ver . '-' . $mtime;
            
        }
    }

}, 100 );