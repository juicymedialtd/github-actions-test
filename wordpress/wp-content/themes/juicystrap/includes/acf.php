<?php
defined('ABSPATH') || exit;

/**
 * Set ACF JSON Save path
 */
function juicystrap_acf_json_save_point()
{
    return get_stylesheet_directory().'/includes/acf-json';
}

add_filter('acf/settings/save_json', 'juicystrap_acf_json_save_point');

/**
 * Set ACF JSON Load path
 * @param $paths
 * @return mixed
 */
function juicystrap_acf_json_load_point($paths)
{
    $paths[] = get_stylesheet_directory().'/includes/acf-json';
    return $paths;
}

add_filter('acf/settings/load_json', 'juicystrap_acf_json_load_point');

