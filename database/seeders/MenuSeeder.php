<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ordering = 1;

        Menu::create([
            'title'       => 'صفحه اصلی',
            'type'        => 'normal',
            'link'        => '/',
            'ordering'    => $ordering++,
        ]);

        Menu::create([
            'title'       => 'محصولات',
            'type'        => 'static',
            'static_type' => 'products',
            'ordering'    => $ordering++,
        ]);

        Menu::create([
            'title'       => 'وبلاگ',
            'type'        => 'static',
            'static_type' => 'posts',
            'ordering'    => $ordering++,
        ]);

        Menu::create([
            'title'       => 'تماس با ما',
            'type'        => 'normal',
            'link'        => '/contact',
            'ordering'    => $ordering++,
        ]);

    }
}
