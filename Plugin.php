<?php namespace Clake\UserExtended;

use Backend\Classes\Controller;
use Clake\UserExtended\Classes\UserExtended;
use System\Classes\PluginBase;
use Event;
use Backend;
use System\Classes\SettingsManager;

/**
 * TODO: Improve readability, documentation, component names and other
 * TODO: Add data-structures dependency
 */

/**
 * UserExtended Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = [
        'RainLab.User',
        'Clake.DataStructures'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'UserExtended',
            'description' => 'Adds roles, friends, and utility functions to the Rainlab User plugin',
            'author'      => 'clake',
            'icon'        => 'icon-user-plus'
        ];
    }

    /**
     * Adds twig filters and functions
     * @return array
     */
    public function registerMarkupTags()
    {
        return [

            'filters' => [

                'timezonify' => ['Clake\Userextended\Classes\TimezoneHandler', 'twigTimezoneAdjustment'],

            ],

        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Registers the UserExtended core module
         */
        Module::register();
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

        /*
         * Boots the modules which were registered with UserExtended
         */
        UserExtended::boot();

        /**
         * Event listener adds the Group Manager button to the side bar of the User backend UI.
         */
        Event::listen('backend.menu.extendItems', function($manager) {

            $manager->addSideMenuItems('RainLab.User', 'user', [
                'groups' => [
                    'label' => 'Group Manager',
                    'url'         => Backend::url('clake/userextended/groupsextended'),
                    'icon'        => 'icon-users',
                    'order'       => 500,
                ],
                'roles' => [
                    'label' => 'Role Manager',
                    'url'         => Backend::url('clake/userextended/roles/manage'),
                    'icon'        => 'icon-pencil',
                    'order'       => 600,
                ],
                'users-side' => [
                    'label' => 'Users',
                    'url'         => Backend::url('rainlab/user/users'),
                    'icon'        => 'icon-user',
                    'order'       => 100,
                ],
            ]);

        });

        return [];

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        //return []; // Remove this line to activate

        return array_merge(
            UserExtended::getComponents(),
            [
                'Clake\UserExtended\Components\UserGroups' => 'usergroups',
                'Clake\UserExtended\Components\ListFriends' => 'friendslist',
                'Clake\UserExtended\Components\UserList' => 'userlist',
                'Clake\UserExtended\Components\ListFriendRequests' => 'friendrequests',
                'Clake\UserExtended\Components\UserSearch' => 'usersearch',
                'Clake\UserExtended\Components\UserUI' => 'userui',
            ]
        );

        /*return [
            'Clake\UserExtended\Components\UserGroups' => 'usergroups',
            'Clake\UserExtended\Components\ListFriends' => 'friendslist',
            'Clake\UserExtended\Components\UserList' => 'userlist',
            'Clake\UserExtended\Components\ListFriendRequests' => 'friendrequests',
            'Clake\UserExtended\Components\UserSearch' => 'usersearch',
            'Clake\UserExtended\Components\UserUI' => 'userui',
            'Clake\UserExtended\Components\Account' => 'account',
            'Clake\UserExtended\Components\Friends' => 'friends',
            'Clake\UserExtended\Components\User' => 'user',
        ];*/
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'UserExtended Settings',
                'description' => 'Manage user extended settings.',
                'category'    => SettingsManager::CATEGORY_USERS,
                'icon'        => 'icon-cog',
                'class'       => 'Clake\Userextended\Models\Settings',
                'order'       => 100,
                'keywords'    => 'security user extended',
                'permissions' => ['']
            ]
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return array_merge(
            UserExtended::getNavigation(),
            [


            ]
        );
    }

}
