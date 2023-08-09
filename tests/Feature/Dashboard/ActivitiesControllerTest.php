<?php

namespace Tests\Feature\Dashboard;

use App\Models\Activity;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivitiesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Create a user and some activities with associated episodes and lessons
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);
        $activity = Activity::factory()->create(['user_id' => $user->id, 'episode_id' => $episode->id]);

        // Make a GET request to the index endpoint
        $response = $this->actingAs($user)->get('/dashboard/activities');

        // Assert the response is successful and the view contains the activity data
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.activities');
        $response->assertViewHas('activities');
        $response->assertSee($activity->episode->title);
    }
}
