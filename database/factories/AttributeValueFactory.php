<?php

namespace Database\Factories;

use App\Models\Attribute as ModelsAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttributeValueFactory extends Factory
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
            'name' => fake()->word(),
            'attribute_uid' => ModelsAttribute::all()->random()->uid
        ];
    }
}
