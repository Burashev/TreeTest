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
                $parentId = rand(1, $category->getKey() - 1);
                $parentChildren = Category::query()->find($parentId)->children()->count();

                $category->update([
                    'parent_id' => $parentId,
                    'index' => $parentChildren
                ]);
            } else {
                $category->update([
                    'index' => $category->getKey() - 1
                ]);
            }
        });
    }
}
