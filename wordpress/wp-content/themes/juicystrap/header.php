<?php defined('ABSPATH') || exit; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div>
    Hello! I'm in the header! <br>
    <i class="fas fa-caret-down" aria-hidden="true"></i>
</div>
