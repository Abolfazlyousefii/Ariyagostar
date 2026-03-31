<?php

return [

    'laravel-version' => '',

    /*
     *
     * Shared translations.
     *
     */
    'title' => 'سیستم نصب اتوماتیک لاراول شاپ',
    'next' => 'بعدی',
    'back' => 'قبلی',
    'finish' => 'نصب',
    'forms' => [
        'errorTitle' => 'خطاهای زیر را برطرف کنید:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'خوش آمدید',
        'title'   => 'سیستم نصب اتوماتیک لاراول شاپ',
        'message' => 'برای نصب فروشگاه آماده اید؟',
        'next'    => 'بررسی نیازمندی ها',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'قدم 1 | نیازمندی های سرور',
        'title' => 'نیازمندی های سرور',
        'next'    => 'بررسی دسترسی ها',
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'قدم 2 | دسترسی ها',
        'title' => 'دسترسی ها',
        'next' => 'تنظیمات اصلی',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'قدم 3 | تنظیمات اصلی',
            'title' => 'تنظیمات اصلی',
            'desc' => 'لطفا نحوه وارد کردن اطلاعات فایل <code class="ltr">env.</code> را انتخاب کنید.',
            'wizard-button' => 'ویرایشگر فرم',
            'classic-button' => 'ویرایشگر متن',
        ],
        'wizard' => [
            'templateTitle' => 'قدم 3 | تنظیمات اصلی | ویرایشگر فرم',
            'title' => 'تنظیمات اصلی',
            'tabs' => [
                'environment' => 'محیط توسعه',
                'database' => 'پایگاه داده',
                'application' => 'اپلیکیشن',
            ],
            'form' => [
                'name_required' => 'An environment name is required.',
                'app_name_label' => 'App Name',
                'app_name_placeholder' => 'App Name',
                'app_environment_label' => 'App Environment',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Development',
                'app_environment_label_qa' => 'Qa',
                'app_environment_label_production' => 'Production',
                'app_environment_label_other' => 'Other',
                'app_environment_placeholder_other' => 'Enter your environment...',
                'app_debug_label' => 'App Debug',
                'app_debug_label_true' => 'True',
                'app_debug_label_false' => 'False',
                'app_log_level_label' => 'App Log Level',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'App Url',
                'app_url_placeholder' => 'App Url',
                'db_connection_failed' => 'Could not connect to the database.',
                'db_connection_label' => 'Database Connection',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'میزبان پایگاه داده',
                'db_host_placeholder' => '',
                'db_port_label' => 'پورت پایگاه داده',
                'db_port_placeholder' => '',
                'db_name_label' => 'نام پایگاه داده',
                'db_name_placeholder' => '',
                'db_username_label' => 'نام کاربری پایگاه داده',
                'db_username_placeholder' => '',
                'db_password_label' => 'رمز عبور پایگاه داده',
                'db_password_placeholder' => '',

                'app_tabs' => [
                    'more_info' => 'More Info',
                    'broadcasting_title' => 'Broadcasting, Caching, Session, Queue',
                    'broadcasting_label' => 'Broadcast Driver',
                    'broadcasting_placeholder' => 'Broadcast Driver',
                    'cache_label' => 'Cache Driver',
                    'cache_placeholder' => 'Cache Driver',
                    'session_label' => 'Session Driver',
                    'session_placeholder' => 'Session Driver',
                    'queue_label' => 'Queue Driver',
                    'queue_placeholder' => 'Queue Driver',
                    'redis_label' => 'Redis Driver',
                    'redis_host' => 'Redis Host',
                    'redis_password' => 'Redis Password',
                    'redis_port' => 'Redis Port',

                    'mail_label' => 'Mail',
                    'mail_driver_label' => 'Mail Driver',
                    'mail_driver_placeholder' => 'Mail Driver',
                    'mail_host_label' => 'Mail Host',
                    'mail_host_placeholder' => 'Mail Host',
                    'mail_port_label' => 'Mail Port',
                    'mail_port_placeholder' => 'Mail Port',
                    'mail_username_label' => 'Mail Username',
                    'mail_username_placeholder' => 'Mail Username',
                    'mail_password_label' => 'Mail Password',
                    'mail_password_placeholder' => 'Mail Password',
                    'mail_encryption_label' => 'Mail Encryption',
                    'mail_encryption_placeholder' => 'Mail Encryption',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App Id',
                    'pusher_app_id_palceholder' => 'Pusher App Id',
                    'pusher_app_key_label' => 'Pusher App Key',
                    'pusher_app_key_palceholder' => 'Pusher App Key',
                    'pusher_app_secret_label' => 'Pusher App Secret',
                    'pusher_app_secret_palceholder' => 'Pusher App Secret',

                    'other_label' => 'Other',
                    'other_app_id_label' => 'Other App Id',

                ],
                'buttons' => [
                    'setup_database' => 'تنظیمات پایگاه داده',
                    'setup_application' => 'نصب',
                    'install' => 'نصب',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'قدم 3 | تنظیمات اصلی | ویرایشگر متن',
            'title' => 'ویرایشگر متنی تنظیمات',
            'save' => 'ذخیره env.',
            'back' => 'استفاده از ویرایشگر فرم',
            'install' => 'ذخیره و نصب',
        ],
        'success' => 'فایل تنظیمات env. شما با موفقیت ذخیره شد.',
        'errors' => 'ایجاد فایل env. ناموفق بود لطفا به صورت دستی ایجاد کنید.',
    ],

    'install' => 'نصب',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'نصب با موفقیت تکمیل شد در تاریخ:  ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'نصب کامل شد',
        'templateTitle' => 'نصب کامل شد',
        'finished' => 'نصب نرم افزار با موفقیت تکمیل شد.',
        'migration' => 'Migration &amp; Seed Console Output:',
        'console' => 'Application Console Output:',
        'log' => 'Installation Log Entry:',
        'env' => 'Final .env File:',
        'exit' => 'اتمام فرآیند نصب',
    ],

    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'Laravel Updater',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Welcome To The Updater',
            'message' => 'Welcome to the update wizard.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Overview',
            'message' => 'There is 1 update.|There are :number updates.',
            'install_updates' => 'Install Updates',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Finished',
            'finished' => 'Application\'s database has been successfully updated.',
            'exit' => 'Click here to exit',
        ],

        'log' => [
            'success_message' => 'Laravel Installer successfully UPDATED on ',
        ],
    ],
];
