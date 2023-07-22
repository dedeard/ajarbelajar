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
        $episodeId = Episode::inRandomOrder()->value('id');
        if (!$episodeId) $episodeId = Episode::factory()->create()->id;

        $userId = User::inRandomOrder()->value('id');
        if (!$userId) $userId = User::factory()->create()->id;

        return [
            'user_id' => $userId,
            'episode_id' => $episodeId,
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
