<?php defined('ABSPATH') || exit;

$category = get_queried_object();
$categoryID = $category->term_id;

get_header(); ?>

    <main>
        <h1><?php _e('Categories for ', 'juicystrap');
            single_cat_title(); ?></h1>

        <?php get_template_part('loop'); ?>

        <?php get_template_part('pagination'); ?>
    </main>

<?php get_footer();
