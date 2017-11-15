<?php
/*
Plugin Name:  Register Theme Directory
Plugin URI:   https://roots.io/bedrock/
Description:  Register default theme directory
Version:      1.0.1
Author:       Roots
Author URI:   https://roots.io/
License:      MIT License
*/
if (!defined('WP_DEFAULT_THEME') || (defined('REGISTER_WP_THEMES') && REGISTER_WP_THEMES)) {
    register_theme_directory(ABSPATH . 'wp-content/themes');
}
