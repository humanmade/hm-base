<?php

// Remove annoying index.php in permalinks settings with Nginx.
add_filter( 'got_rewrite', '__return_true', 999 );

/**
 * Fix login loop.
 *
 * If you go to /wp-admin/ when wordpress is in a subdirectory, it cleverly redirects you to /subdir/wp-login.ph
 * But... it appends reauth=1 to the url... which forces a reauthentication on a succesful login... wierd right!
 */
add_filter( 'login_url', function( $url ) {

	if ( '/wp-admin/' === add_query_arg( array() ) ) {
		$url = remove_query_arg( 'reauth', $url );
		$url = add_query_arg( 'redirect_to', get_admin_url(), $url );
	}
	
	return $url;

} );