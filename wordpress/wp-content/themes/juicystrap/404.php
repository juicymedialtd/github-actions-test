<?php
defined('ABSPATH') || exit;

get_header();
?>
<main>
    <h1>
        <?php _e('Error 404 - Page Not Found', 'juicystrap'); ?>
    </h1>
    <p>
        <?php _e('Before you go, consider:', 'juicystrap'); ?>
    </p>
    <ul>
        <li><?php _e('Double checking your spelling.', 'juicystrap'); ?></li>
        <li><?php _e('Try similar keywords in your search.', 'juicystrap'); ?></li>
        <li><?php _e('Using more than one keyword in your search.', 'juicystrap'); ?></li>
    </ul>
</main>
<?php get_footer(); ?>
