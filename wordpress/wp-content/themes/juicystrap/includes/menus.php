<?php
defined('ABSPATH') || exit;

function juicystrap_menus()
{
    register_nav_menu('navbar', 'Navbar');
}

add_action('after_setup_theme', 'juicystrap_menus');
