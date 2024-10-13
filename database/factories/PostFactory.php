<?php

namespace Database\Factories;

use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'text' => fake()->text(),
            'active' => fake()->boolean(),
            'post_type_id' => PostType::all()->random()->id
        ];
    }
}
