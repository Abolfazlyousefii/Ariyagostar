<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(StaticFilterSeeder::class);
        $this->call(LinkSeeder::class);
    }
}
