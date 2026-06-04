<?php

namespace TSJIPPY\POSITIONALACCOUNTS;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\loadAssets');
function loadAssets()
{
    wp_register_script('tsjippy_positional_script', TSJIPPY\pathToUrl(PLUGINPATH . 'js/positional.min.js'), [], PLUGINVERSION, true);
}
