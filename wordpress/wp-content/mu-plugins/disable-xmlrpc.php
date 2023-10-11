<?php
/*
Plugin Name: Disable XMLRPC
Description: Disables XMLRPC
Author: Juicy Media
Version: 1.0
Author URI: https://juicy.media
*/

add_filter( 'xmlrpc_enabled', '__return_false' );
