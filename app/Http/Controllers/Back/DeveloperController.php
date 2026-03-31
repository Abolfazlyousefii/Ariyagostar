<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Codedge\Updater\UpdaterManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeveloperController extends Controller
{
    public function showSettings()
    {
        // Get last schedule run time
        $schedule_last_work = option('schedule_run');
        $schedule_run       = false;
        $random_str         = str_random(15);

        if ($schedule_last_work) {
            if (!is_object($schedule_last_work)) {
                $schedule_last_work = Carbon::createFromDate($schedule_last_work);
            }

            $diff = $schedule_last_work->diffInMinutes(now());
            $schedule_run = ($diff <= 2);
        }

        return view('back.developer.settings', compact('schedule_run', 'random_str'));
    }

    public function updateSettings(Request $request)
    {
        // Update developer options
        $developer_options = $request->except(['SELF_UPDATER_HTTP_PRIVATE_ACCESS_TOKEN']);

        foreach ($developer_options as $option => $value) {
            option_update($option, $value);
        }

        // Update APP_DEBUG in .env
        if ($request->app_debug_mode) {
            change_env('APP_DEBUG', 'true');
        } else {
            change_env('APP_DEBUG', 'false');
        }

        // Update enable_help_videos option
        if ($request->enable_help_videos) {
            option_update('enable_help_videos', 'true');
        } else {
            option_update('enable_help_videos', 'false');
        }

        // Update updater token in .env
        change_env('SELF_UPDATER_HTTP_PRIVATE_ACCESS_TOKEN', $request->SELF_UPDATER_HTTP_PRIVATE_ACCESS_TOKEN);

        // Update DEBUGBAR_ENABLED in .env
        if ($request->debugbar_enabled) {
            change_env('DEBUGBAR_ENABLED', 'true');
        } else {
            change_env('DEBUGBAR_ENABLED', 'false');
        }

        if ($request->enable_old_updates) {
            option_update('enable_old_updates', 'true');
        } else {
            option_update('enable_old_updates', 'false');
        }


        return response('success');
    }

    public function downApplication(Request $request)
    {
        // Validate secret input
        $request->validate([
            'secret' => 'required|string'
        ]);

        // Update down options
        $down_options = $request->except(['secret']);

        foreach ($down_options as $option => $value) {
            option_update($option, $value);
        }

        // Put application in maintenance mode
        Artisan::call("down --render='errors::503' --secret='$request->secret'");

        return response()->json(['secret' => $request->secret]);
    }

    public function upApplication()
    {
        // Bring application out of maintenance mode
        Artisan::call("up");

        return response('success');
    }

    public function webpushNotification()
    {
        // Generate VAPID keys for webpush
        Artisan::call('webpush:vapid');

        return response('success');
    }

    public function showUpdater(UpdaterManager $updater)
    {
        // Check if updater token is set
        $token = config('self-update.updater_token');

        if (!$token) {
            toastr()->error('برای بروزرسانی نرم افزار لطفا شماره سفارش راست چین را وارد کنید.');
            return redirect()->route('admin.developer.settings');
        }

        $updateType = request('type', 'stable');

        // Get current PHP version
        $phpVersion = phpversion();
        $phpMajorMinor = substr($phpVersion, 0, 3);

        // List of supported PHP versions from config
        $supportedPhpVersions = config('self-update.supported_php_versions', ['7.4', '8.0', '8.1', '8.2', '8.3']);

        // Find the closest supported PHP version (matching or lower)
        rsort($supportedPhpVersions, SORT_NUMERIC);
        $selectedPhpVer = null;
        foreach ($supportedPhpVersions as $ver) {
            if ((float) $ver <= (float) $phpMajorMinor) {
                $selectedPhpVer = $ver;
                break;
            }
        }

        // Initialize default values for fallback
        $isNewVersionAvailable = false;
//     $versionAvailable =  // Default to current version
        $versionInstalled = config('self-update.version_installed');
        $repositoryAvailable = false;
        $hasNextUpgrade = false;
        $nextVersion = $nextPhpVersion = $recommendedPhpVersion = null;

        // Override repository_url based on selected PHP version and update type
        $envRepoUrl ='http://laravel-shop.ir/updates/';
        $baseUrl = rtrim(dirname($envRepoUrl), '/');
        $phpSpecificUrl = $selectedPhpVer ? $baseUrl . '/php' . str_replace('.', '_', $selectedPhpVer) . "-updates/{$updateType}" : $baseUrl . '/updates';
        Config::set('self-update.repository_types.http.repository_url', $phpSpecificUrl);

        try {
            // Check for updates in PHP-specific repository
            $isNewVersionAvailable = $updater->source()->isNewVersionAvailable();
            $versionAvailable = $updater->source()->getVersionAvailable();
            $versionInstalled = $updater->source()->getVersionInstalled();
            $repositoryAvailable = true;

            Log::info("Repository check successful for URL: {$phpSpecificUrl}");
            Log::info("Available version: {$versionAvailable}, Installed version: {$versionInstalled}");

        } catch (Exception $e) {
            // Handle repository connection errors
            Log::warning("Failed to connect to repository {$phpSpecificUrl}: " . $e->getMessage());
            Log::warning("Falling back to 'latest version' message");

            $repositoryAvailable = false;
            $isNewVersionAvailable = false;
            $versionAvailable = 'N/A (مخزن در دسترس نیست)';
            $hasNextUpgrade = false;
        }


        if (!$repositoryAvailable) {
            $versionInstalled = config('self-update.version_installed');
        }

        return view('back.developer.updater', compact(
            'isNewVersionAvailable',
            'versionAvailable',
            'versionInstalled',
            'phpVersion',
            'repositoryAvailable',
            'hasNextUpgrade',
            'nextVersion',
            'nextPhpVersion',
            'recommendedPhpVersion',
            'updateType'
        ));
    }

    public function checkNextPhpUpdates(UpdaterManager $updater)
    {

        // Get current PHP version
        $phpVersion = phpversion();
        $phpMajorMinor = substr($phpVersion, 0, 3); // e.g., '8.1'

        // List of supported PHP versions from config
        $supportedPhpVersions = config('self-update.supported_php_versions', ['7.4', '8.0', '8.1', '8.2','8.4']);

        // Find the closest supported PHP version (matching or HIGHER)
        rsort($supportedPhpVersions, SORT_NUMERIC);
        $selectedPhpVer = null;
        foreach ($supportedPhpVersions as $ver) {
            if ((float) $ver <= (float) $phpMajorMinor) {
                $selectedPhpVer = $ver;
                break;
            }
        }
        Log::info($selectedPhpVer);
        $envRepoUrl = 'http://laravel-shop.ir/updates/';
        $baseUrl = rtrim(dirname($envRepoUrl), '/');
        $currentUrl = $baseUrl . '/php' . str_replace('.', '_', $selectedPhpVer) . "-updates/stable";
        $versionAvailable = '0.0.0';
        try {
            Config::set('self-update.repository_types.http.repository_url', $currentUrl);
            $versionAvailable = $updater->source()->getVersionAvailable();
            Log::info("Current PHP version available: {$versionAvailable} from URL: {$currentUrl}");
        } catch (Exception $e) {
            Log::warning("Failed to get current version: " . $e->getMessage());
        }

        // Find next HIGHER PHP versions and their HIGHEST available versions
        $nextPhpVersions = [];
        sort($supportedPhpVersions, SORT_NUMERIC);
        $currentIndex = array_search($selectedPhpVer, $supportedPhpVersions);

        for ($i = $currentIndex + 1; $i < count($supportedPhpVersions); $i++) {
            $nextVer = $supportedPhpVersions[$i];
            $nextUrl = $baseUrl . '/php' . str_replace('.', '_', $nextVer) . "-updates/stable";

            try {
                $response = Http::timeout(10)->get($nextUrl);
                if ($response->successful()) {
                    $html = $response->body();
                    Log::info("HTML response for {$nextUrl}: " . substr($html, 0, 200));
                    preg_match_all('/href="([^"]*\.zip)"/', $html, $matches);
                    $zipFiles = $matches[1] ?? [];
                    Log::info("Found ZIP files for PHP {$nextVer}: " . json_encode($zipFiles));
                    $versions = [];
                    foreach ($zipFiles as $file) {
                        if (preg_match('/webapp-v(\d+\.\d+\.\d+)/', $file, $versionMatch)) {
                            $versions[] = $versionMatch[1];
                        }
                    }

                    if (!empty($versions)) {
                        rsort($versions, SORT_NATURAL);
                        $highestVersion = $versions[0];

                        $nextPhpVersions[] = [
                            'php' => $nextVer,
                            'version' => $highestVersion,
                            'url' => $nextUrl,
                            'allVersions' => $versions
                        ];
                        Log::info("Next PHP version {$nextVer} HIGHEST available: {$highestVersion} (all: " . implode(', ', $versions) . ")");
                    } else {
                        Log::warning("No valid ZIP files found for PHP {$nextVer}");
                    }
                } else {
                    Log::warning("HTTP failed for {$nextUrl}: " . $response->status());
                }
            } catch (Exception $e) {
                Log::warning("Failed to check next PHP version {$nextVer} from {$nextUrl}: " . $e->getMessage());
            }
        }
        $hasNextUpgrade = false;
        $nextVersion = null;
        $nextPhpVersion = null;
        $recommendedPhpVersion = null;
        if (!empty($nextPhpVersions)) {
            usort($nextPhpVersions, function ($a, $b) {
                return version_compare($b['version'], $a['version']);
            });
            $nextVersion = $nextPhpVersions[0]['version'];
            $nextPhpVersion = $nextPhpVersions[0]['php'];
            $hasNextUpgrade = version_compare($nextVersion, $versionAvailable, '>');
            $recommendedPhpVersion = $hasNextUpgrade ? $nextPhpVersion : null;

            Log::info("FINAL - Current: {$versionAvailable}, Next: {$nextVersion}, Has Upgrade: " . ($hasNextUpgrade ? 'YES' : 'NO'));
        }

        return response()->json([
            'hasNextUpgrade' => $hasNextUpgrade,
            'nextVersion' => $nextVersion,
            'nextPhpVersion' => $nextPhpVersion,
            'recommendedPhpVersion' => $recommendedPhpVersion,
            'currentVersion' => $versionAvailable,
            'debug' => [
                'currentUrl' => $currentUrl,
                'nextPhpVersions' => $nextPhpVersions
            ]
        ]);
    }

    public function updateApplication(UpdaterManager $updater)
    {
        try {
            Log::info("=== UPDATE STARTED ===");
            Log::info("Current repository_url: " . config('self-update.repository_types.http.repository_url'));
            // ⭐ این بخش را اضافه کنید - شروع
            $updateType = request('type', 'stable');

            $phpVersion = phpversion();
            $phpMajorMinor = substr($phpVersion, 0, 3);

            $supportedPhpVersions = config('self-update.supported_php_versions', ['7.4', '8.0', '8.1', '8.2', '8.3']);
            rsort($supportedPhpVersions, SORT_NUMERIC);

            $selectedPhpVer = null;
            foreach ($supportedPhpVersions as $ver) {
                if ((float) $ver <= (float) $phpMajorMinor) {
                    $selectedPhpVer = $ver;
                    break;
                }
            }
            $envRepoUrl = 'http://laravel-shop.ir/updates/';
            $baseUrl = rtrim(dirname($envRepoUrl), '/');
            $phpSpecificUrl = $selectedPhpVer
                ? $baseUrl . '/php' . str_replace('.', '_', $selectedPhpVer) . "-updates/{$updateType}"
                : $baseUrl . '/updates';

            Config::set('self-update.repository_types.http.repository_url', $phpSpecificUrl);

            Log::info("update repository url is {$phpSpecificUrl}");
            Log::info("After config - repository_url: " . config('self-update.repository_types.http.repository_url'));
            $versionAvailable = $updater->source()->getVersionAvailable();
            $versionInstalled = $updater->source()->getVersionInstalled();
            Log::info("Version available: {$versionAvailable}");

            try {
                Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])->get(config('general.api_url') . '/shop/update', [
                    'host' => url('/') ?: config('app.url'),
                    'time' => now(),
                    'script' => 'shop',
                    'versionAvailable' => $versionAvailable,
                    'versionInstalled' => $versionInstalled,
                    'server_ip' => request()->server('SERVER_ADDR'),
                    'updater_ip' => request()->ip(),
                ]);
            } catch (Exception $e) {
                Log::warning("Failed to send update info to API: " . $e->getMessage());
            }

            Artisan::call('updater:update');

            return response('success');
        } catch (Exception $e) {
            Log::error("Update failed: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            Log::error("Update failed: " . $e->getMessage());
            return response()->json(['error' => 'خطا در بروزرسانی: ' . $e->getMessage()], 500);
        }
    }

    public function updaterAfter()
    {
        try {
            Artisan::call('updater:after');
            return response('success');
        } catch (Exception $e) {
            Log::error("Post-update commands failed: " . $e->getMessage());
            return response()->json(['error' => 'خطا در اجرای دستورات بعد از بروزرسانی: ' . $e->getMessage()], 500);
        }
    }
    public function oldShowUpdater(UpdaterManager $updater)
    {
        $token = config('self-update.updater_token');

        if (!$token) {
            toastr()->error('برای بروزرسانی نرم افزار لطفا شماره سفارش راست چین را وارد کنید.');
            return redirect()->route('admin.developer.settings');
        }

        $isNewVersionAvailable = $updater->source()->isNewVersionAvailable();
        $versionAvailable = $updater->source()->getVersionAvailable();
        $versionInstalled = $updater->source()->getVersionInstalled();

        return view('back.developer.old-updater', compact(
            'isNewVersionAvailable',
            'versionAvailable',
            'versionInstalled'
        ));
    }
    public function oldUpdateApplication(UpdaterManager $updater)
    {
        $versionAvailable = $updater->source()->getVersionAvailable();
        $versionInstalled = $updater->source()->getVersionInstalled();

        try {
            Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('general.api_url') . '/shop/update', [
                'host'                => url('/') ?: config('app.url'),
                'time'                => now(),
                'script'              => 'shop',
                'versionAvailable'    => $versionAvailable,
                'versionInstalled'    => $versionInstalled,
                'server_ip'           => request()->server('SERVER_ADDR'),
                'updater_ip'          => request()->ip(),
            ]);
        } catch (Exception $e) {
            // just continue
        }


        Artisan::call('updater:update');

        return response('success');
    }


}
