<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdaterAfter extends Command
{
    protected $signature = 'updater:after';
    protected $description = 'run this command after update';

    public function handle()
    {
        $this->runArtisanCommands();
//        $this->fixPublicUploadsPermissions();
//        $this->fixBootstrapCachePermissions();
        return 0;
    }

    protected function runArtisanCommands()
    {
        $commands = [
            'optimize:clear',
            ['migrate', ['--force' => true]],
            ['db:seed', ['class' => 'PermissionSeeder', '--force' => true]],
            'app:fix',
            'shop:link',
            'queue:restart',
            'optimize',
            'theme:config',
        ];

        foreach ($commands as $cmd) {
            try {
                is_array($cmd)
                    ? $this->call($cmd[0], $cmd[1] ?? [])
                    : $this->call($cmd);
            } catch (Exception $e) {
                $this->logError("Artisan command failed: " . (is_array($cmd) ? $cmd[0] : $cmd), $e);
            }
        }
    }

    protected function fixPublicUploadsPermissions()
    {
        $path = public_path('uploads');
        if (!file_exists($path)) return;

        $user = $this->getWebUserSafely();

        $this->safeShell("find {$path} -type d -exec chmod 755 {} \\;");
        $this->safeShell("find {$path} -type f -exec chmod 644 {} \\;");

        if ($user) {
            $this->silentChown("chown -R {$user}:{$user} {$path}");
        }
    }

    protected function fixBootstrapCachePermissions()
    {
        $path = base_path('bootstrap/cache');
        if (!file_exists($path)) return;

        $user = $this->getWebUserSafely();

        $this->safeShell("chmod -R 775 {$path}");

        if ($user) {
            $this->silentChown("chown -R {$user}:{$user} {$path}");
        }
    }

    protected function safeShell($command)
    {
        try {
            exec($command . ' 2>&1', $output, $returnCode);
            if ($returnCode !== 0) {
                throw new Exception("Exit code: {$returnCode}\n" . implode("\n", $output));
            }
        } catch (Exception $e) {
            $this->logError("Critical shell command failed: {$command}", $e);
        }
    }

    protected function silentChown($command)
    {
        exec($command . ' 2>&1', $output, $returnCode);
    }

    protected function getWebUserSafely()
    {
        if (!extension_loaded('posix')) {
            return 'www-data';
        }

        try {
            $common = ['www-data', 'nginx', 'apache', 'nobody', 'http', 'web', 'wwwrun'];
            foreach ($common as $user) {
                if (posix_getpwnam($user)) {
                    return $user;
                }
            }
        } catch (Exception $e) {
            $this->logError('posix_getpwnam failed', $e);
        }

        return 'www-data';
    }

    protected function logError($message, Exception $e)
    {
        $fullMessage = "{$message}: " . $e->getMessage();
        $this->error($fullMessage);
        Log::error('UpdaterAfter Critical Error', [
            'message' => $message,
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
