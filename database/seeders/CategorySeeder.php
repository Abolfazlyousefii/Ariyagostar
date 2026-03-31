<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ordering = 1;

        $faker = Factory::create();
        Storage::disk('public')->makeDirectory('uploads/categories');

        for ($i = 0; $i < 3; $i++) {
            $image = $faker->image(Storage::disk('public')->path('uploads/categories'), 100, 100);
            $image = substr($image, strpos($image, 'uploads'));

            Category::create([
                'title'    => 'دسته بندی تستی',
                'slug'     => 'دسته بندی تستی ' . $i,
                'type'     => 'productcat',
                'image'    => str_replace('public', '', $image),
                'ordering' => $ordering++,
            ]);
        }
    }
}
