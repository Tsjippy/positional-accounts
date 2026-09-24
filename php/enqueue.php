<?php

namespace TSJIPPY\POSITIONALACCOUNTS;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\loadAssets');
/**
 * Registeres the js
 */
function loadAssets()
{
    $deps   = SCRIPT_DEBUG ? [  
        '@tsjippy/form_submit_functions', 
        "@tsjippy/webauth", 
        "@tsjippy/show_loader", 
        "@tsjippy/display_message"
    ] :
    [];

    $deps[] = "@tsjippy/nonce_script";
    wp_register_script_module('@tsjippy/positional_script', TSJIPPY\pathToUrl(PLUGINPATH . 'js/positional' . TSJIPPY\JSEXTENSION), $deps, PLUGINVERSION);
}
