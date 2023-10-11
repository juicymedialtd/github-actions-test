<?php
defined('ABSPATH') || exit;

function juicystrap_enqueue()
{
    // Deregister styles
    $deregister_styles = [
        // 'style-handle',
    ];
    foreach ($deregister_styles as $handle) {
        wp_deregister_style($handle);
    }

    // Deregister, Register and Enqueue styles
    $styles = [
        [
            'handle' => 'juicystrap-style',
            'src' => get_stylesheet_directory_uri().'/assets/dist/css/app.css',
            'deps' => null,
            'ver' => juicystrap_get_asset_ver('/css/app.css')
        ],
    ];

    foreach ($styles as $style) {
        wp_deregister_style($style['handle']);
        wp_register_style(
            $style['handle'],
            $style['src'],
            $style['deps'],
            $style['ver']
        );
        wp_enqueue_style($style['handle']);
    }

    // Deregister scripts
    $deregister_scripts = [
        // 'script-handle',
    ];
    foreach ($deregister_scripts as $handle) {
        wp_deregister_script($handle);
    }

    // Deregister, Register and Enqueue scripts
    // Use https://www.srihash.org/ to generate integrity hash for external scripts
    $scripts = [
        [
            'handle' => 'jquery',
            'src' => 'https://code.jquery.com/jquery-3.6.0.min.js',
            'integrity' => 'sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK',
            'in_footer' => true,
        ],
        [
            'handle' => 'jquery-migrate',
            'src' => 'https://code.jquery.com/jquery-migrate-3.3.2.min.js',
            'deps' => ['jquery'],
            'integrity' => 'sha384-Pm1fyRwPgIbpBpjdSYtcKzBv+Z/nHekZIGmhoVSBTSJ+cynSJChqUaVhkQZvb7FV',
            'in_footer' => true,
        ],
        [
            'handle' => 'popper',
            'src' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js',
            'integrity' => 'sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB',
            'in_footer' => true,
        ],
        [
            'handle' => 'bootstrap',
            'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js',
            'deps' => ['jquery'],
            'integrity' => 'sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13',
            'in_footer' => true,
        ],
        [
            'handle' => 'juicystrap-script-manifest',
            'src' => get_stylesheet_directory_uri().'/assets/dist/js/manifest.js',
            'ver' => juicystrap_get_asset_ver('/js/manifest.js'),
            'in_footer' => true,
        ],
        [
            'handle' => 'juicystrap-script-vendor',
            'src' => get_stylesheet_directory_uri().'/assets/dist/js/vendor.js',
            'ver' => juicystrap_get_asset_ver('/js/vendor.js'),
            'in_footer' => true,
        ],
        [
            'handle' => 'juicystrap-script-app',
            'src' => get_stylesheet_directory_uri().'/assets/dist/js/app.js',
            'ver' => juicystrap_get_asset_ver('/js/app.js'),
            'in_footer' => true,
//            'localize' => [
//                [
//                    'juicystrapJs',
//                    [
//                        'ajax_url' => admin_url('admin-ajax.php'),
//                        'nonce' => wp_create_nonce('ajax_nonce'),
//                    ]
//                ]
//            ],
        ],
    ];

    foreach ($scripts as $script) {
        if (isset($script['condition']) && !$script['condition']) {
            continue;
        }

        wp_deregister_script($script['handle']);
        wp_register_script(
            $script['handle'],
            $script['src'],
            $script['deps'] ?? '',
            $script['ver'] ?? null,
            $script['in_footer'] ?? false,
        );

        if (!empty($script['integrity'])) {
            juicystrap_script_integrity($script['handle'], $script['integrity']);
        }

        wp_enqueue_script($script['handle']);

        foreach (($script['localize'] ?? []) as $localize) {
            wp_localize_script($script['handle'], $localize[0], $localize[1]);
        }
    }
}

add_action('wp_enqueue_scripts', 'juicystrap_enqueue');
