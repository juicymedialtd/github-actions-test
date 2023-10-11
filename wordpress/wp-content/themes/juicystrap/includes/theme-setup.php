<?php
defined('ABSPATH') || exit;

function juicystrap_after_setup_theme()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption',]);

    load_theme_textdomain('juicystrap', get_template_directory().'/languages');
}

add_action('after_setup_theme', 'juicystrap_after_setup_theme');

add_filter('auto_update_theme', '__return_false');
add_filter('auto_update_plugin', '__return_false');
add_filter('plugins_auto_update_enabled', '__return_false');
add_filter('themes_auto_update_enabled', '__return_false');
