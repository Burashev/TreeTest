<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
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
            'title' => fake()->word,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Category $category) {
            if ($category->getKey() > 10) {
                $category->update(['parent_id' => rand(1, $category->getKey() - 1)]);
            }
        });
    }
}
