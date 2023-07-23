<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::inRandomOrder()->value('id') ?? User::factory()->create()->id,
            'episode_id' => fn () => Episode::inRandomOrder()->value('id') ?? Episode::factory()->create()->id,
            'body' => json_encode([
                "blocks" => [
                    [
                        "type" => "heading",
                        "data" => [
                            "text" => fake()->text(),
                        ],
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => fake()->paragraph(),
                        ],
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => fake()->paragraph(),
                        ],
                    ],
                ],
            ]),
        ];
    }
}
