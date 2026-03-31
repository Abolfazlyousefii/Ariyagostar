<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Madnest\Madzipper\Madzipper;

class ThemeController extends Controller
{
    public function index()
    {
        $this->authorize('themes.index');

        $themes = Storage::disk('themes')->directories();

        foreach ($themes as $key => $theme) {
            $themes[$key] = [
                'name'   => $theme,
                'config' => customConfig(base_path() . '/themes/' . $theme . '/config/general.php')
            ];
        }

        return view('back.themes.index', compact('themes'));
    }

    public function store(Request $request)
    {
        $this->authorize('themes.create');

        $request->validate([
            'file' => 'required|file|mimes:zip'
        ]);

        $uuid = uniqid();
        $path = Storage::disk('public')->path('uploads/tmp/');

        $file = $request->file;
        $name = $uuid . '.' . $file->getClientOriginalExtension();
        $request->file->storeAs('tmp', $name);

        $zipper = new Madzipper;
        $zipper->make($path . $name)->extractTo($path . $uuid);
        $zipper->close();

        File::delete($path . $name);

        $themes = Storage::disk('themes')->directories();
        $new_theme = Storage::disk('public')->directories('uploads/tmp/' . $uuid);
        $new_theme = substr($new_theme[0], strrpos($new_theme[0], '/') + 1);

        if (in_array($new_theme, $themes)) {

            File::deleteDirectory($path . $uuid);

            return response(
                [
                    'errors' => [
                        'theme' => ["این قالب قبلا آپلود شده است."]
                    ]
                ],
                422
            );
        }

        File::moveDirectory($path . $uuid . '/' . $new_theme, Storage::disk('themes')->path($new_theme));
        File::deleteDirectory($path . $uuid);

        change_env('CURRENT_THEME', $new_theme);
        Artisan::call('dump-autoload');

        AppServiceProvider::loadTheme();
        Artisan::call('vendor:publish --tag="' . $new_theme . '" --force');
        Artisan::call('shop:link');

        return response()->json(['name' => $new_theme]);
    }

    public function create()
    {
        $this->authorize('themes.create');

        return view('back.themes.create');
    }

    public function update($theme)
    {
        $this->authorize('themes.update');

        if (!Storage::disk('themes')->exists($theme)) {
            return response(
                [
                    'errors' => [
                        'theme' => ["قالب پیدا نشد."]
                    ]
                ],
                422
            );
        }

        change_env('CURRENT_THEME', $theme);

        return response('success');
    }

    public function destroy($theme)
    {
        $this->authorize('themes.delete');

        if (!Storage::disk('themes')->exists($theme)) {
            return response(
                [
                    'errors' => [
                        'theme' => ["قالب پیدا نشد."]
                    ]
                ],
                422
            );
        }

        $config = customConfig(base_path() . '/themes/' . $theme . '/config/general.php');
        Storage::disk('themes')->deleteDirectory($theme);
        Storage::disk('public')->deleteDirectory($config['asset_path']);

        return response('success');
    }

    public function showSettings()
    {
        $this->authorize('themes.settings');

        return view('back.themes.settings');
    }

    public function updateSettings(Request $request)
    {
        $this->authorize('themes.settings');

        Validator::make($request->settings, config('front.settings.rules'))->validate();

        $settings = $this->getRequestSettings($request);

        foreach ($settings as $setting => $value) {
            option_update($setting, $value);
        }

        return response('success');
    }

    private function getRequestSettings($request)
    {
        $settings = [];

        foreach (config('front.settings.fields') as $setting) {
            switch ($setting['input-type']) {
                case 'input':
                case 'editor':
                case 'inline-editor':
                case 'select': {
                        $settings[$setting['key']] = $request->input('settings.' . $setting['key']);
                        break;
                    }

                case 'file': {
                        $file = $request->file('settings.' . $setting['key']);

                        if ($file) {
                            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs('themes', $name);
                            $settings[$setting['key']] = '/uploads/' . $path;
                        } else {
                            $settings[$setting['key']] = option($setting['key']);
                        }

                        break;
                    }
            }
        }

        return $settings;
    }
}
