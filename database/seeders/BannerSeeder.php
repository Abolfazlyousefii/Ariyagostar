<?php

namespace Database\Seeders;

use App\Models\Banner;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('public')->makeDirectory('uploads/banners');

        if (config('front.bannerGroups')) {
            foreach (config('front.bannerGroups') as $bannerGroup) {
                for ($i = 0; $i < $bannerGroup['count']; $i++) {

                    $image = '';

                    if (isset($bannerGroup['images'])) {
                        $demo_image_path = $bannerGroup['images'][$i] ?? $bannerGroup['images'][0];
                        $path            = public_path('uploads/banners/') . basename($demo_image_path);
                        $image           = substr($path, strpos($path, 'uploads'));

                        File::copy(theme_path($demo_image_path), $path);
                    }

                    Banner::create([
                        'link'        => '#',
                        'group'       => $bannerGroup['group'],
                        'published'   => true,
                        'image'       => str_replace('public', '', $image)
                    ]);
                }
            }
        }
    }
}
