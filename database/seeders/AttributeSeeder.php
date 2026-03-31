<?php

namespace Database\Seeders;

use App\Models\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = AttributeGroup::create([
            'name' => 'رنگ',
            'type' => 'color',
        ]);

        $attributes = [
            [
                'name'  => 'آبی',
                'value' => '#0008fb',
            ],
            [
                'name'  => 'قرمز',
                'value' => '#fb0000',
            ],
            [
                'name'  => 'طلایی',
                'value' => '#d2b800bf',
            ],
        ];

        foreach ($attributes as $attribute) {
            $group->get_attributes()->create([
                'name'  => $attribute['name'],
                'value' => $attribute['value'],
            ]);
        }

        $group = AttributeGroup::create([
            'name' => 'گارانتی',
            'type' => 'checkbox',
        ]);

        $attributes = [
            [
                'name'  => 'گارانتی شرکتی',
                'value' => null,
            ],
            [
                'name'  => 'گارانتی اصل بودن کالا',
                'value' => null,
            ],
            [
                'name'  => 'بدون گارانتی',
                'value' => null,
            ],
        ];

        foreach ($attributes as $attribute) {
            $group->get_attributes()->create([
                'name'  => $attribute['name'],
                'value' => $attribute['value'],
            ]);
        }

        $group = AttributeGroup::create([
            'name' => 'اندازه',
            'type' => 'checkbox',
        ]);

        $attributes = [
            [
                'name'  => 'L',
                'value' => null,
            ],
            [
                'name'  => 'XL',
                'value' => null,
            ],
            [
                'name'  => 'S',
                'value' => null,
            ],
        ];

        foreach ($attributes as $attribute) {
            $group->get_attributes()->create([
                'name'  => $attribute['name'],
                'value' => $attribute['value'],
            ]);
        }
    }
}
