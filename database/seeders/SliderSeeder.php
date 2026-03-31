<?php

namespace Database\Seeders;

use App\Models\Slider;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ordering = 1;

        Storage::disk('public')->makeDirectory('uploads/sliders');

        if (config('front.sliderGroups')) {
            foreach (config('front.sliderGroups') as $sliderGroup) {
                for ($i = 0; $i < $sliderGroup['count']; $i++) {

                    $image = '';

                    if (isset($sliderGroup['images'])) {
                        $demo_image_path = $sliderGroup['images'][$i] ?? $sliderGroup['images'][0];
                        $path            = public_path('uploads/sliders/') . basename($demo_image_path);
                        $image           = substr($path, strpos($path, 'uploads'));

                        File::copy(theme_path($demo_image_path), $path);
                    }

                    Slider::create([
                        'link'        => '#',
                        'title'       => $sliderGroup['titles'][$i] ?? '',
                        'group'       => $sliderGroup['group'],
                        'published'   => true,
                        'image'       => str_replace('public', '', $image),
                        'ordering'    => $ordering++
                    ]);
                }
            }
        }
    }
}
