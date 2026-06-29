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

        // Show a table with one positional account per row and all the accounts linked to it.
        $table  = addElement('table', $parent, ['class' => 'tsjippy table']);
        $tr     = addElement('tr', $table);
        addElement('th', $tr, [], 'Name');
        addElement('th', $tr, [], 'Linked to');

        foreach ($users as $user) {
            $linkedUserIds = get_user_meta($user->ID, 'tsjippy_linked_accounts');

            if (is_array($linkedUserIds)) {
                $names    = [];
                foreach ($linkedUserIds as $linkedUserId) {
                    $linkedUser  = get_user($linkedUserId);

                    if ($linkedUser) {
                        $names[] = $linkedUser->display_name;
                    }
                }

                $tr     = addElement('tr', $table);

                $td     = addElement('td', $tr);

                $url    = get_edit_profile_url($user->ID)."?user-id=$user->ID&main-tab=login-info";

                addElement('a', $td, ['href' => $url], $user->display_name);

                $td     = addElement('td', $tr);
                if (!empty($names)) {
                    foreach($names as $name){
                        $td->append($name);
                        addElement('br', $td);
                    }
                }else{
                    $td->append("No user linked to this account ");
                    addElement('br', $td);
                    addElement('a', $td, ['href' => $url], 'Link now');
                }
            }
        }

        return true;
    }

    public function functions($parent)
    {

        return false;
    }
}
