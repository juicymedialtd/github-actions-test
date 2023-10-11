<?php
/*
Plugin Name: Ignore Deprecated Debug Notices
Description: Ignores PHP Deprecated notices when WP_DEBUG is enabled
Author: Juicy Media
Version: 1.0
Author URI: https://juicy.media
*/

if (defined('WP_DEBUG') && WP_DEBUG) {
    error_reporting(E_ALL ^ E_DEPRECATED);

    // Add class when php error is deprecated
    add_action('admin_head', function () {
        $error_get_last = error_get_last();
        if (
            ($error_get_last && WP_DEBUG && WP_DEBUG_DISPLAY && ini_get('display_errors') && (E_NOTICE !== $error_get_last['type'] || 'wp-config.php' !== wp_basename($error_get_last['file'])))
            && E_DEPRECATED === $error_get_last['type']
        ) {
            add_filter('admin_body_class', fn() => ' deprecated-php-error');
        }
        unset($error_get_last);
    });
}
