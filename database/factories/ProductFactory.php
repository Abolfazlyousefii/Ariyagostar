<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'              => $this->faker->realText(30),
            'slug'               => $this->faker->realText(30),
            'title_en'           => $this->faker->sentence,
            'type'               => 'physical',
            'category_id'        => $this->faker->numberBetween(1, 3),
            'spec_type_id'       => null,
            'image'              => null,
            'price_type'         => 'multiple-price',
            'weight'             => $this->faker->numberBetween(100, 1000),
            'description'        => $this->faker->realText(2000),
            'short_description'  => $this->faker->realText(500),
            'special'            => $this->faker->boolean,
            'published'          => true,
        ];
    }
}
