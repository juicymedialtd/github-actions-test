<?php
defined('ABSPATH') || exit;

$types = [
    // 'file-name',
];

foreach ($types as $type) {
    require_once locate_template('/includes/taxonomies/'.$type.'.php');
}

