<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->name(),
            'email'=>fake()->unique()->safeEmail(),
            'phone'=>fake()->phoneNumber(),
            'address'=>fake()->address(),
            'status'=>fake()->randomElement(['PENDING','CONFIRM','CANCELLED','DONE']),
            'created_at'=>fake()->date('Y-m-d H:i:s'),
            'updated_at'=>fake()->date('Y-m-d H:i:s')
        ];
    }
}
