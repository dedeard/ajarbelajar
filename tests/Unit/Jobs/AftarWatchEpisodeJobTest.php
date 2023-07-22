<?php

namespace Tests\Unit\Jobs;

use App\Jobs\AftarWatchEpisodeJob;
use App\Models\Activity;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AftarWatchEpisodeJobTest extends TestCase
{
    use RefreshDatabase;

    public function testJobHandlesCorrectly()
    {
        // Create a mock Episode and User
        $episode1 = Episode::factory()->create();
        $episode2 = Episode::factory()->create();
        $episode3 = Episode::factory()->create();
        $user = User::factory()->create();

        // Dispatch the job
        dispatch(new AftarWatchEpisodeJob($episode1, $user));

        // Assert that the activity was created or updated
        $this->assertDatabaseHas('activities', ['episode_id' => $episode1->id, 'user_id' => $user->id]);

        // Assert that the activity count is capped at 20
        for ($i = 0; $i < 3; $i++) {
            dispatch(new AftarWatchEpisodeJob($episode1, $user));
        }
        $this->assertEquals(1, $user->activities()->count());

        dispatch(new AftarWatchEpisodeJob($episode2, $user));

        dispatch(new AftarWatchEpisodeJob($episode3, $user));

        $this->assertEquals(3, $user->activities()->count());
    }

    public function testJobHandlesCorrectlyWithoutUser()
    {
        // Create a mock Episode
        $episode = Episode::factory()->create();

        // Dispatch the job without a user
        dispatch(new AftarWatchEpisodeJob($episode));

        // Assert that no activity is created or updated because there's no user
        $this->assertDatabaseMissing('activities', ['episode_id' => $episode->id]);
    }
}
