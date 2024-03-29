<?php

namespace Tests\Unit\Jobs;

use App\Events\EpisodeWatchedEvent;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EpisodeWatchedJobTest extends TestCase
{
    use RefreshDatabase;

    public function testJobHandlesCorrectly()
    {
        // Create a mock Episode and User
        $episode1 = Episode::factory()->create();
        $user = User::factory()->create();

        // Dispatch the event
        EpisodeWatchedEvent::dispatch($episode1, $user);

        // Assert that the history was created or updated
        $this->assertDatabaseHas('histories', ['episode_id' => $episode1->id, 'user_id' => $user->id]);

        // Assert that the history count is capped at 20
        for ($i = 0; $i < 3; $i++) {
            EpisodeWatchedEvent::dispatch($episode1, $user);
        }
        $this->assertEquals(1, $user->histories()->count());

        $episode2 = Episode::factory()->create();
        EpisodeWatchedEvent::dispatch($episode2, $user);

        $episode3 = Episode::factory()->create();
        EpisodeWatchedEvent::dispatch($episode3, $user);

        $this->assertEquals(3, $user->histories()->count());
    }

    public function testJobHandlesCorrectlyWithoutUser()
    {
        // Create a mock Episode
        $episode = Episode::factory()->create();

        // Dispatch the event without a user
        EpisodeWatchedEvent::dispatch($episode);

        // Assert that no history is created or updated because there's no user
        $this->assertDatabaseMissing('histories', ['episode_id' => $episode->id]);
    }
}
