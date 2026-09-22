<?php

namespace TSJIPPY\POSITIONALACCOUNTS;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\loadAssets');
function loadAssets()
{
    $deps   = SCRIPT_DEBUG ? [  
        '@tsjippy/form_submit_functions', 
        "@tsjippy/webauth", 
        "@tsjippy/show_loader", 
        "@tsjippy/display_message"
    ] :
    [];
    wp_register_script_module('@tsjippy/positional_script', TSJIPPY\pathToUrl(PLUGINPATH . 'js/positional' . TSJIPPY\JSEXTENSION), $deps, PLUGINVERSION);
}
