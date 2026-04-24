<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('ru_RU');
        return [
            'name' => $faker->unique()->realText(20),
            'description' => $faker->realText(100),
            'price' => $faker->numberBetween(100, 10000),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
