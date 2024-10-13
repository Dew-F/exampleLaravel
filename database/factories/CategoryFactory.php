<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryType;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
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
            'parent_uid' => fake()->boolean(50) && Category::all()->count() > 0 ? Category::all()->random()->uid : null,
            'category_type_id' => CategoryType::all()->random()->id,
            'active' => fake()->boolean(),
            'category_footer_title' => fake()->title(),
            'category_footer_text' => fake()->text()
        ];
    }
}
