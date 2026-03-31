<?php

namespace App\Providers;

use Exception;
// use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;

class MyEnvironmentManager extends EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        parent::__construct();

        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
            'APP_NAME=\'' . 'laravel-shop' . "'\n" .
            'APP_ENV=' . 'local' . "\n" .
            'APP_KEY=' . 'base64:' . base64_encode(Str::random(32)) . "\n" .
            'APP_DEBUG=' . 'false' . "\n" .
            'DEBUGBAR_ENABLED=' . 'false' . "\n" .
            'APP_URL=' . url('/') . "\n\n" .
            'LOG_LEVEL=' . 'debug' . "\n" .
            'DB_CONNECTION=' . $request->database_connection . "\n" .
            'DB_HOST=' . $request->database_hostname . "\n" .
            'DB_PORT=' . $request->database_port . "\n" .
            'DB_DATABASE=' . $request->database_name . "\n" .
            'DB_USERNAME=' . $request->database_username . "\n" .
            'DB_PASSWORD=' . $request->database_password . "\n\n" .
            'CURRENT_THEME=' . 'DefaultTheme' . "\n" .
            'BROADCAST_DRIVER=' . 'log' . "\n" .
            'CACHE_DRIVER=' . 'file' . "\n" .
            'SESSION_DRIVER=' . 'file' . "\n" .
            'QUEUE_CONNECTION=' . 'sync' . "\n\n" .
            'SESSION_LIFETIME=' . '120' . "\n\n" .
            'REDIS_HOST=' . '127.0.0.1' . "\n" .
            'REDIS_PASSWORD=' . 'null' . "\n" .
            'REDIS_PORT=' . '6379' . "\n\n" .
            'REDIS_CLIENT=' . 'predis' . "\n\n" .
            'MAIL_DRIVER=' . 'smtp' . "\n" .
            'MAIL_HOST=' . 'smtp.mailtrap.io' . "\n" .
            'MAIL_PORT=' . '2525' . "\n" .
            'MAIL_USERNAME=' . '' . "\n" .
            'MAIL_PASSWORD=' . '' . "\n" .
            'MAIL_ENCRYPTION=' . 'tls' . "\n\n" .
            'CURRENT_THEME=' . 'DefaultTheme' . "\n\n" .
            'PUSHER_APP_ID=' . '' . "\n" .
            'PUSHER_APP_KEY=' . '' . "\n" .
            'PUSHER_APP_SECRET=' . '' . "\n" .
            'MIX_PUSHER_APP_KEY=' . '"${PUSHER_APP_KEY}"' . "\n" .
            'MIX_PUSHER_APP_CLUSTER=' . '"${PUSHER_APP_CLUSTER}"' . "\n\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
