<?php
defined('ABSPATH') || exit;

include_once(ABSPATH.'wp-admin/includes/plugin.php'); // include so we can use `is_plugin_active()`

$files = [
    'helpers', // Include first to ensure helper functions are available throughout the theme
    'acf',
    'disable-emojis',
    'enqueue',
    'images',
    'menus',
    'pagination',
    'post-types',
    'posts',
    'taxonomies',
    'theme-setup',
];

foreach ($files as $file) {
    require_once locate_template('/includes/'.$file.'.php');
}
