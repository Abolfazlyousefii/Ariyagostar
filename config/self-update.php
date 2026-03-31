<?php


if (!function_exists('get_temp_download_path')) {
    function get_temp_download_path(): string
    {
        $systemTmp = sys_get_temp_dir();
        if (@is_writable($systemTmp)) {
            return $systemTmp;
        }
        if (@is_dir('/.cagefs/tmp') && @is_writable('/.cagefs/tmp')) {
            return '/.cagefs/tmp';
        }
        if (@is_dir('/home/.tmp') && @is_writable('/home/.tmp')) {
            return '/home/.tmp';
        }
        return storage_path('app');
    }
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default source repository type
    |--------------------------------------------------------------------------
    |
    | The default source repository type you want to pull your updates from.
    |
    */

    'default' => env('SELF_UPDATER_SOURCE', 'http'),

    /*
    |--------------------------------------------------------------------------
    | Supported PHP versions
    |--------------------------------------------------------------------------
    |
    | List of supported PHP versions for repository overrides.
    |
    */

    'supported_php_versions' => ['7.4', '8.0', '8.1', '8.2', '8.4'],

    /*
    |--------------------------------------------------------------------------
    | Version installed
    |--------------------------------------------------------------------------
    |
    | Set this to the version of your software installed on your system.
    |
    */

    'version_installed' => '1.18.9',

    /*
    |--------------------------------------------------------------------------
    | Updater Token
    |--------------------------------------------------------------------------
    |
    | This token is used when updating software
    |
    */

    'updater_token' => env('SELF_UPDATER_HTTP_PRIVATE_ACCESS_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Repository types
    |--------------------------------------------------------------------------
    |
    | A repository can be of different types, which can be specified here.
    | Current options:
    | - github
    | - http
    |
    */

    'repository_types' => [
        'github' => [
            'type' => 'github',
            'repository_vendor' => env('SELF_UPDATER_REPO_VENDOR', ''),
            'repository_name' => env('SELF_UPDATER_REPO_NAME', ''),
            'repository_url' => '',
            'download_path' => env('SELF_UPDATER_DOWNLOAD_PATH', '/tmp'),
            'private_access_token' => env('SELF_UPDATER_GITHUB_PRIVATE_ACCESS_TOKEN', ''),
            'use_branch' => env('SELF_UPDATER_USE_BRANCH', ''),
        ],
        'http' => [
            'type' => 'http',
            'repository_url' => env('SELF_UPDATER_REPO_URL', 'http://laravel-shop.ir/updates/'),
            'pkg_filename_format' => env('SELF_UPDATER_PKG_FILENAME_FORMAT', 'webapp-v_VERSION_'),
            'download_path' => env('SELF_UPDATER_DOWNLOAD_PATH', get_temp_download_path()),
            'private_access_token' => env('SELF_UPDATER_HTTP_PRIVATE_ACCESS_TOKEN', ''),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude folders from update
    |--------------------------------------------------------------------------
    |
    | Specific folders which should not be updated and will be skipped during the
    | update process.
    |
    | Here's already a list of good examples to skip. You may want to keep those.
    |
    */

    'exclude_folders' => [
        '__MACOSX',
        'node_modules',
        'storage/app',
        'storage/framework',
        'storage/logs',
        'storage/self-update',
        'public/uploads',
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Logging
    |--------------------------------------------------------------------------
    |
    | Configure if fired events should be logged
    |
    */

    'log_events' => env('SELF_UPDATER_LOG_EVENTS', true), // Set to true for debugging

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | Specify for which events you want to get notifications. Out of the box you can use 'mail'.
    |
    */

    'notifications' => [
        'notifications' => [
            // \Codedge\Updater\Notifications\Notifications\UpdateSucceeded::class => ['mail'],
            // \Codedge\Updater\Notifications\Notifications\UpdateFailed::class => ['mail'],
            // \Codedge\Updater\Notifications\Notifications\UpdateAvailable::class => ['mail'],
        ],

        /*
         * Here you can specify the notifiable to which the notifications should be sent. The default
         * notifiable will use the variables specified in this config file.
         */
        'notifiable' => \Codedge\Updater\Notifications\Notifiable::class,

        'mail' => [
            'to' => [
                'address' => env('SELF_UPDATER_MAILTO_ADDRESS', 'notifications@example.com'),
                'name' => env('SELF_UPDATER_MAILTO_NAME', ''),
            ],

            'from' => [
                'address' => env('SELF_UPDATER_MAIL_FROM_ADDRESS', 'updater@example.com'),
                'name' => env('SELF_UPDATER_MAIL_FROM_NAME', 'Update'),
            ],
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Register custom artisan commands
    |---------------------------------------------------------------------------
    */

    'artisan_commands' => [
        'pre_update' => [
            //'command:signature' => [
            //    'class' => Command class
            //    'params' => []
            //]
        ],
        'post_update' => [
            'updater:after' => [
                'class' => \App\Console\Commands\UpdaterAfter::class,
                'params' => []
            ]
        ],
    ],

];
