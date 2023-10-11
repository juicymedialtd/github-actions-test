<?php
defined('ABSPATH') || exit;

/**
 * Image Sizes
 */
remove_image_size('1536x1536');
remove_image_size('2048x2048');

// Register image sizes
$images_sizes = [
    // ['size-handle', width, height, crop],
    // e.g ['featured', 550, 300, true],
];

// Scaled sized for srcset
$scaled = [1.5, 2, 3, 4];

foreach ($images_sizes as $s) {
    add_image_size($s[0], $s[1], $s[2], $s[3] ?? false);

    foreach ($scaled as $scale) {
        add_image_size($s[0].'@'.$scale.'x', $s[1] * $scale, $s[2] * $scale, $s[3] ?? false);
    }
}

/**
 * Removes the width and height attributes of <img> tags for SVG
 * @link https://wordpress.stackexchange.com/a/240589
 *
 * @wp-hook image_downsize
 * @param  mixed  $out  Value to be filtered
 * @param  int  $id  Attachment ID for image.
 * @return bool|array False if not in admin or not SVG. Array otherwise.
 */
function juicystrap_fix_svg_size_attributes($out, $id)
{
    $image_url = wp_get_attachment_url($id);
    $file_ext = pathinfo($image_url, PATHINFO_EXTENSION);

    if (is_admin() || 'svg' !== $file_ext) {
        return false;
    }

    return array($image_url, null, null, false);
}

add_filter('image_downsize', 'juicystrap_fix_svg_size_attributes', 10, 2);

/**
 * Remove srcset max width
 *
 * @param $max_width
 * @return false
 */
function juicystrap_remove_max_srcset_image_width($max_width)
{
    return false;
}

add_filter('max_srcset_image_width', 'juicystrap_remove_max_srcset_image_width');
