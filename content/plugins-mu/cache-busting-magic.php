<?php

/**
 *
 * Add file last modified time to version param of of enqueued scripts & styles
 * 
 * This automagically busts cache whenever there is a change in a file.
 */

add_action( 'wp_enqueue_scripts', function() {

    global $wp_styles, $wp_scripts;

    foreach ( array( 'wp_styles', 'wp_scripts' ) as $resource ) {

        foreach ( $$resource->registered as $name => $registered_resource ) {
            if ( false === stripos( $name, 'wpr-' ) )
                continue;

            $file = str_replace( 'wordpress/', '', str_replace( home_url( '/' ), ABSPATH, $registered_resource->src ) );
            $mtime = filectime( $file );
            $$resource->registered[$name]->ver = $$resource->registered[$name]->ver . '-' . $mtime;
        }
    }
    
}, 100 );