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
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'category_id' => function () {
                return Category::factory()->create()->id;
            },
            'cover' => fake()->imageUrl(640, 480), // You can adjust the image size as per your requirement
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'description' => fake()->paragraph,
            'public' => fake()->boolean,
            'posted_at' => fake()->dateTimeThisYear,
        ];
    }
}
