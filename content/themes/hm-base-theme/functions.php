<?php

/**
 * Theme Functions
 *
 * @package WordPress
 * @subpackage HM_Base_Theme
 */


/**
 * Get the theme version.
 * Return version defined in style.css
 *
 * @return string version.
 * @since 0.1.0
 */
function hmbase_get_theme_version() {

	//  wp_get_theme since WordPress 3.4.0
	if ( function_exists( 'wp_get_theme' ) ) {
		$theme = wp_get_theme( basename( get_bloginfo( 'stylesheet_directory' ) ) );
		$version = $theme->version;
	} else {
		$theme = get_theme_data( get_bloginfo( 'stylesheet_directory' ) . '/style.css' );
		$version = $theme['Version'];
	}

	return apply_filters( 'hmbase_get_theme_version', $version );

}

/**
 * Check whether currently running a live or dev environment.
 *
 * Uses value of HM_DEV.
 *
 * @return bool is dev
 * @since 0.1.0
 */
function hmbase_is_dev() {

	return apply_filters( 'hmbase_is_dev', defined( 'HM_DEV' ) && true === HM_DEV );

}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @return null
 * @since 0.1.0
 */
function hmbase_scripts_styles() {

	$version = hmbase_get_theme_version();
	$postfix = ( hmbase_is_dev() ) ? '' : '.min';

	wp_enqueue_script( 'hmbase-theme', get_template_directory_uri() . "/assets/js/theme{$postfix}.js", array(), $version, true );

	wp_enqueue_style( 'hmbase-theme', get_template_directory_uri() . "/assets/css/theme{$postfix}.css", array(), $version );

	// Livereload. To use, run 'grunt watch'.
	if ( hmbase_is_dev() ) {
		wp_enqueue_script( 'hmbase-livereload', home_url() . ':35729/livereload.js' ); // When running grunt watch inside vagrant.
		// wp_enqueue_script( 'hmbase-livereload', 'http://localhost:35729/livereload.js' ); // When running grunt watch on your machine.
	}


}
add_action( 'wp_enqueue_scripts', 'hmbase_scripts_styles' );
