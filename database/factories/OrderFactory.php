<?php

namespace Database\Factories;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'manager_id' => Manager::all()->random()->id,
            'order_status' => fake()->boolean(),
            'full_name' => fake()->name(),
            'telephone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'total' => fake()->randomFloat(2, 0, 100000000000),
        ];
    }
}
