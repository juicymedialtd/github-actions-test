<?php
defined('ABSPATH') || exit;

function juicystrap_pagination($offset = false) {
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    if ($offset) {
        $max = intval(ceil(max(0, $wp_query->found_posts - 7) / 12));

        if (is_numeric(basename($_SERVER['REQUEST_URI']))) {
            $paged = intval(basename($_SERVER['REQUEST_URI']));
        } else {
            $paged = 1;
        }
    } else {
        $max = intval($wp_query->max_num_pages);
        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    }

    if ($paged >= 1) {
        $links[] = $paged;
    }

    if ($paged >= 3) {
        $links[] = $paged - 1;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 1;
    }

    if ($paged === 1) {
        $prevClass = 'disabled';
        $prevAttribute = 'tabindex="-1"';
    } else {
        $prevClass = '';
        $prevAttribute = '';
    }

    if ($paged === $max) {
        $nextClass = 'disabled';
        $nextAttribute = 'tabindex="-1"';
    } else {
        $nextClass = '';
        $nextAttribute = '';
    }

    echo '<div class="bg-white p-3 text-center" aria-label="Page navigation">';
    echo '<ul class="pagination">';
    echo '<li class="page-item ' . $prevClass . '"><a ' . $prevAttribute . ' href="' . esc_url(get_pagenum_link(1)) . '" class="page-link">' . __('Start', 'juicystrap') . '</a></li>';
    echo '<li class="page-item ' . $prevClass . '"><a ' . $prevAttribute . ' href="' . esc_url(get_pagenum_link($paged - 1)) . '" class="page-link"><span class="d-none d-md-block">' . __('Prev', 'juicystrap') . '</span><span class="icon d-md-none"><i class="far fa-chevron-left"></i></span></a></li>';
    echo '</li>';

    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' active' : '';
        printf('<li class="page-item%s"><a href="%s" class="page-link%s">%s</a></li>', $class, esc_url(get_pagenum_link(1)), $class, '1');
        if (!in_array(2, $links)) {
            echo '<li class="page-item disabled" aria-disabled="true"><span class="page-link">&hellip;</span></li>';
        }
    }
    sort($links);
    foreach ((array)$links as $link) {
        $class = $paged == $link ? ' active' : '';
        printf('<li class="page-item%s"><a href="%s" class="page-link">%s</a></li>', $class, esc_url(get_pagenum_link($link)), $link);
    }
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) {
            echo '<li class="page-item disabled" aria-disabled="true"><span class="page-link">&hellip;</span></li>';
        }
        $class = $paged == $max ? ' active' : '';
        printf('<li class="page-item%s"><a href="%s" class="page-link">%s</a></li>', $class, esc_url(get_pagenum_link($max)), $max);
    }
    echo '<li class="page-item ' . $nextClass . '"><a ' . $nextAttribute . ' href="' . esc_url(get_pagenum_link($paged + 1)) . '" class="page-link"><span class="d-none d-md-block">' . __('Next', 'juicystrap') . '</span><span class="icon d-md-none"><i class="far fa-chevron-right"></i></span></a></li>';
    echo '<li class="page-item ' . $nextClass . '"><a ' . $nextAttribute . ' href="' . esc_url(get_pagenum_link($max)) . '" class="page-link">' . __('End', 'juicystrap') . '</a></li>';
    echo '</ul>';
    echo '<div class="pagination-meta">' . __('Page ' . $paged . ' of ' . $max, 'juicystrap') . '</div>';
    echo '</div>';
}

add_filter('next_posts_link_attributes', 'juicystrap_next_posts_link_class');
add_filter('previous_posts_link_attributes', 'juicystrap_previous_posts_link_class');

function juicystrap_next_posts_link_class() {
    return 'class="page-link"';
}

function juicystrap_previous_posts_link_class() {
    return 'class="page-link"';
}
