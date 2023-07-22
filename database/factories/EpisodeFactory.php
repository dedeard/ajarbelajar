<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lesson_id' => function () {
                return Lesson::factory()->create()->id;
            },
            'name' => fake()->word,
            'title' => fake()->sentence,
            'index' => fake()->randomNumber(2),
            'seconds' => fake()->randomNumber(3),
        ];
    }
}
