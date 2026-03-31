<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('front.linkGroups')) {
            foreach (config('front.linkGroups') as $linkGroup) {
                for ($i = 0; $i < 3; $i++) {
                    Link::create([
                        'title'            => 'تست',
                        'link'             => '#',
                        'link_group_id'    => $linkGroup['key'],
                        'ordering'         => Link::max('ordering') + 1,
                    ]);
                }
            }
        }
    }
}
