<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductFeedback>
 */
class ProductFeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'of_product'=>fake()->numberBetween(1,80),
            'created_by'=>fake()->numberBetween(1,20),
            'rating'=>fake()->numberBetween(1,5),
            'feedback'=>fake()->text(250),
            'created_at'=>fake()->date('Y-m-d H:i:s'),
            'updated_at'=>fake()->date('Y-m-d H:i:s'),
        ];
    }
}
