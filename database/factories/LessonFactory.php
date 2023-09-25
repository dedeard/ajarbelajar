<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create()->id,
            'category_id' => function () {
                $categories = Category::all();
                $ids = $categories->map(fn ($c) => $c->id);
                if (count($ids)) {
                    return $ids->random();
                }
                return Category::factory()->create()->id;
            },
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'description' => fake()->paragraph,
            'public' => fake()->boolean,
            'posted_at' => fake()->dateTimeThisYear,
        ];
    }
}
