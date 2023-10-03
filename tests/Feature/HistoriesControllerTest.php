<?php

namespace Tests\Feature\Dashboard;

use App\Models\Episode;
use App\Models\History;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoriesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Create a user and some histories with associated episodes and lessons
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);
        $history = History::factory()->create(['user_id' => $user->id, 'episode_id' => $episode->id]);

        // Make a GET request to the index endpoint
        $response = $this->actingAs($user)->get('/histories');

        // Assert the response is successful and the view contains the history data
        $response->assertStatus(200);
        $response->assertViewIs('histories');
        $response->assertViewHas('histories');
        $response->assertSee($history->episode->title);
    }
}
