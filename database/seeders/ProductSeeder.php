<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory(5)->create();

        foreach ($products as $product) {
            $product->prices()->create(
                [
                    "price"          => 200000,
                    "discount"       => 3,
                    "discount_price" => get_discount_price(200000, 3, $product),
                    "regular_price"  => get_discount_price(200000, 0, $product),
                    "stock"          => 5,
                ]
            );
        }
    }
}
