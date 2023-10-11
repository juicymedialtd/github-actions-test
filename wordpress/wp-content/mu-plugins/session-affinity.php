<?php
/*
Plugin Name: AWS Session Affinity
Description: Enables session affinity on AWS
Author: Juicy Media
Version: 1.0
Author URI: https://juicy.media
*/

add_action('init', function () {
    if (is_login() || is_user_logged_in()) {
        setcookie('SESSION_AFFINITY', 'yes', time() + 60 * 60 * 24);
    } elseif (isset($_COOKIE['SESSION_AFFINITY'])) {
        unset($_COOKIE['SESSION_AFFINITY']);
        setcookie('SESSION_AFFINITY', '', time() - 3600, '/'); // empty value and old timestamp
    }
});
