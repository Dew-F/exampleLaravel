<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'uid' => fake()->uuid(),
            'name' => $name = fake()->unique()->text(50),
            'slug' => str_slug($name),
            'price' => fake()->randomFloat(2, 0, 1000000),
            'description' => fake()->text(),
            'article' => fake()->uuid(),
            'availability' => fake()->uuid(),
            'category_uid' => Category::all()->random()->uid,
            'video' => '6KaHIXRQtf0'.';'.'6KaHIXRQtf0'.';'.'6KaHIXRQtf0',
            'active' => fake()->boolean(),
            'category_type_id' => rand(1, 3)
        ];
    }
}
