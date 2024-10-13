<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'mail' => fake()->unique()->safeEmail(),
            'phone' => fake()->randomNumber(),
            'telegram_id' => fake()->randomNumber(),
            'display' => fake()->boolean(),
            'active' => fake()->boolean(),
            'is_admin' => fake()->boolean(),
        ];
    }
}
