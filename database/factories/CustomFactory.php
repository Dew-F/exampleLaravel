<?php

namespace Database\Factories;

use App\Models\Manager;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Custom>
 */
class CustomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'text' => fake()->text(),
            'date' => fake()->date(),
            'manager_id' => Manager::all()->random()->id,
            'product_uid' => Product::all()->random()->uid
        ];
    }
}
