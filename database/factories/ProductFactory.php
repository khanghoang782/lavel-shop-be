<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'product_name' => fake()->name(),
            'description' => fake()->text(250),
            'price' => fake()->numberBetween(90000, 990000),
            'stock' => fake()->numberBetween(1, 10),
            'created_at' => fake()->dateTime('now'),
            'catalog_id' => fake()->numberBetween(1, 4),
        ];
    }
}
