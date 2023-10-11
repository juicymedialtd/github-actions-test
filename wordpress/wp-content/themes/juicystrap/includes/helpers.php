<?php defined('ABSPATH') || exit;

/**
 * Add SRI attributes to enqueued script tags
 *
 * @param  string  $handle
 * @param  string  $hash
 */
function juicystrap_script_integrity(string $handle, string $hash)
{
    add_filter('script_loader_tag', function ($tag, $loaded_handle) use ($handle, $hash) {
        if ($handle === $loaded_handle) {
            $attrs = 'integrity="'.$hash.'" crossorigin="anonymous"';
            return str_replace("src", $attrs." src", $tag);
        }
        return $tag;
    }, 10, 2);
}

/**
 * Get the version of an asset from mix-manifest.json
 * Useful for cache-busting
 *
 * @param  string  $file  The file name, as it appears as a key in mix-manifest.json
 * @return string The version
 */
function juicystrap_get_asset_ver(string $file)
{
    $manifest = json_decode(file_get_contents(get_stylesheet_directory().'/assets/dist/mix-manifest.json'), true);

    if ($manifest && array_key_exists($file, $manifest)) {
        return str_replace($file.'?id=', '', $manifest[$file]);
    } else {
        return '';
    }
}
