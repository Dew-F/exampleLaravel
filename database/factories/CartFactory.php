<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_uid' => Product::all()->random()->uid,
            'session_id' => Session::all()->random()->id,
            'count' => fake()->randomNumber()
        ];
    }
}
