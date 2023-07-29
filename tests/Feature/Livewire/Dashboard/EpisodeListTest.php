<?php

namespace Tests\Feature\Livewire\Dashboard;

use App\Http\Livewire\Dashboard\EpisodeList;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class EpisodeListTest extends TestCase
{
    use RefreshDatabase;

    public function testMountMethodSetsDurationAndEpisodeTitle()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);
        $seconds = 3600; // 1 hour
        $episode = Episode::factory()->create(['lesson_id' => $lesson->id, 'seconds' => $seconds]);

        Livewire::actingAs($user)
            ->test(EpisodeList::class, ['episode' => $episode])
            ->assertSet('duration', '01:00:00')
            ->assertSet('episode_title', $episode->title);
    }

    public function testUpdatedEpisodeTitleUpdatesEpisodeTitle()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);
        $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);

        Livewire::actingAs($user)
            ->test(EpisodeList::class, ['episode' => $episode])
            ->set('episode_title', 'New Episode Title')
            ->assertSet('episode.title', 'New Episode Title');
    }

    public function testDestroyMethodDeletesEpisode()
    {
        // Prevent the actual event from being dispatched during the test
        Event::fake();

        $user = User::factory()->create();
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);
        $episode = Episode::factory()->create(['lesson_id' => $lesson->id, 'name' => 'test_episode.mp4']);

        // Ensure the episode exists before deletion
        $this->assertDatabaseHas('episodes', ['id' => $episode->id]);

        Livewire::actingAs($user)
            ->test(EpisodeList::class, ['episode' => $episode])
            ->call('destroy')
            ->assertEmitted('episode-deleted');

        // Ensure the episode is deleted from the database
        $this->assertDatabaseMissing('episodes', ['id' => $episode->id]);
    }
}
