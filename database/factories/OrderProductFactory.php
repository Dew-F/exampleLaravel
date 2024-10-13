<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'order_id' => Order::all()->random()->id,
            'product_uid' =>  Product::all()->count() > 0 ? Product::all()->random()->uid : null,
            'count' => fake()->randomNumber(),
        ];
    }
}
