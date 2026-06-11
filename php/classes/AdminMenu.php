<?php

namespace TSJIPPY\POSITIONALACCOUNTS;

use TSJIPPY;

use function TSJIPPY\addElement;

if (! defined('ABSPATH')) {
    exit;
}

class AdminMenu extends TSJIPPY\ADMIN\SubAdminMenu
{

    /**
     * AdminMenu constructor.
     *
     * @param array $settings The settings for the plugin
     * @param string $name The name of the plugin
     */
    public function __construct($settings, $name)
    {
        parent::__construct($settings, $name);
    }

    public function settings($parent)
    {
        return false;
    }

    public function emails($parent)
    {
        return false;
    }

    public function data($parent = '')
    {
        $args = array(
            'meta_query' => array(
                array(
                    'key'       => 'tsjippy_account-type',
                    'value'     => 'positional',
                    'compare'   => '='
                )
            )
        );
        $users      = get_users($args);

        if (empty($users)) {
            return false;
        }

        $url        = '';
        if (defined('TSJIPPY\USERMANAGEMENT\SETTINGS')) {
            $url   = get_permalink(TSJIPPY\USERMANAGEMENT\SETTINGS['user-edit-page'] ?? '');

            if (!$url) {
                $url = '';
            }
        }

        $url        = "?user-id=";

        // Show a table with one positional account per row and all the accounts linked to it.
        $table  = addElement('table', $parent, ['class' => 'tsjippy table']);
        $tr     = addElement('tr', $table);
        addElement('th', $tr, [], 'Name');
        addElement('th', $tr, [], 'Linked to');


        foreach ($users as $user) {
            $linkedUserIds     = get_user_meta($user->ID, 'tsjippy_linked-accounts', true);

            $name            = "No user linked to this account <a href='$url$user->ID&main-tab=login-info'>Link now</a>";

            if (is_array($linkedUserIds)) {
                $names    = [];
                foreach ($linkedUserIds as $linkedUserId) {
                    $linkedUser        = get_user($linkedUserId);

                    if ($linkedUser) {
                        $names[]        = $linkedUser->display_name;
                    }
                }

                if (!empty($names)) {
                    $name    = implode("\n", $names);
                }

                $tr     = addElement('tr', $table);

                $td     = addElement('td', $table);
                addElement('a', $td, ['href' => "$url$user->ID&main-tab=login-info"]);


                $td     = addElement('td', $table, [], $name);
            }
        }

        return true;
    }

    public function functions($parent)
    {

        return false;
    }
}
