<?php

namespace Tests\Feature\Livewire\Dashboard;

use App\Http\Livewire\Dashboard\ShowEpisodes;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowEpisodesTest extends TestCase
{
  use RefreshDatabase;

  public function testShowEpisodesRendersCorrectly()
  {
    // Create a user and a public lesson
    $user = User::factory()->create();
    $lesson = Lesson::factory()->create(['user_id' => $user->id, 'public' => true]);

    // Livewire test: render the ShowEpisodes component and pass the lesson data
    $component = Livewire::actingAs($user)
      ->test(ShowEpisodes::class, ['lesson' => $lesson])
      ->assertSet('lesson', $lesson) // Assert that the lesson data is correctly set in the component
      ->assertDontSeeLivewire('dashboard.episode-list') // Assert that the episode list is not shown when there are no episodes
      ->assertStatus(200); // Assert that the Livewire response status is 200 (OK)

    // Create an episode and emit the 'episode-created' event
    $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $component->emit('episode-created')
      ->assertSeeLivewire('dashboard.episode-list'); // Assert that the episode list is shown after creating an episode

    // Delete the episode and emit the 'episode-deleted' event
    $episode->delete();
    $component->emit('episode-deleted')
      ->assertDontSeeLivewire('dashboard.episode-list'); // Assert that the episode list is not shown after deleting the episode
  }
  public function testUpdatedIndexUpdatesEpisodeOrder()
  {
    // Create a user and a lesson
    $user = User::factory()->create();
    $lesson = Lesson::factory()->create(['user_id' => $user->id]);

    // Create three episodes for the lesson
    $episode1 = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $episode2 = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $episode3 = Episode::factory()->create(['lesson_id' => $lesson->id]);

    // Livewire test: render the ShowEpisodes component and pass the lesson data
    Livewire::actingAs($user)
      ->test(ShowEpisodes::class, ['lesson' => $lesson])
      ->set('index', "$episode3->id,$episode2->id,$episode1->id");

    // Assert that the episode order is updated correctly in the database
    $this->assertDatabaseHas('episodes', [
      'id' => $episode3->id,
      'index' => 0, // The index of $episode3 should be 0 after reordering
    ]);

    $this->assertDatabaseHas('episodes', [
      'id' => $episode2->id,
      'index' => 1, // The index of $episode2 should be 1 after reordering
    ]);

    $this->assertDatabaseHas('episodes', [
      'id' => $episode1->id,
      'index' => 2, // The index of $episode1 should be 2 after reordering
    ]);
  }

  public function testUpdatedIndexDoesNotUpdateEpisodeOrderForDifferentLesson()
  {
    // Create a user and a lesson
    $user = User::factory()->create();
    $lesson = Lesson::factory()->create(['user_id' => $user->id]);

    // Create three episodes for the lesson
    $episode1 = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $episode2 = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $episode3 = Episode::factory()->create(['lesson_id' => $lesson->id]);

    // Livewire test: render the ShowEpisodes component and pass the lesson data
    Livewire::actingAs($user)
      ->test(ShowEpisodes::class, ['lesson' => $lesson])
      ->set('index', "$episode1->id,$episode2->id,$episode3->id");

    // Assert that the episode order remains the same as it was before reordering,
    // because the index values passed for reordering belong to the same lesson.
    $this->assertDatabaseHas('episodes', [
      'id' => $episode3->id,
      'index' => 2, // The index of $episode3 should remain 2 after reordering
    ]);

    $this->assertDatabaseHas('episodes', [
      'id' => $episode2->id,
      'index' => 1, // The index of $episode2 should remain 1 after reordering
    ]);

    $this->assertDatabaseHas('episodes', [
      'id' => $episode1->id,
      'index' => 0, // The index of $episode1 should remain 0 after reordering
    ]);
  }

  public function testUpdatedIndexDoesNotUpdateEpisodeOrderForUnauthorizedUser()
  {
    // Create two users, user1 will be the owner of the lesson, and user2 will be unauthorized.
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Create a lesson owned by user1
    $lesson = Lesson::factory()->create(['user_id' => $user1->id]);

    // Create three episodes for the lesson
    $episode1 = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $episode2 = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $episode3 = Episode::factory()->create(['lesson_id' => $lesson->id]);

    // Livewire test: render the ShowEpisodes component and pass the lesson data,
    // but acting as user2 (a different user, not the owner of the lesson).
    Livewire::actingAs($user2)
      ->test(ShowEpisodes::class, ['lesson' => $lesson])
      ->set('index', "$episode3->id,$episode2->id,$episode1->id");

    // Assert that the episode order remains unchanged, as user2 is not authorized to
    // reorder the episodes of this lesson, and the episode index should not be updated.
    $this->assertDatabaseHas('episodes', [
      'id' => $episode1->id,
      'index' => $episode1->index, // The index of $episode1 should remain the same
    ]);

    $this->assertDatabaseHas('episodes', [
      'id' => $episode2->id,
      'index' => $episode2->index, // The index of $episode2 should remain the same
    ]);

    $this->assertDatabaseHas('episodes', [
      'id' => $episode3->id,
      'index' => $episode3->index, // The index of $episode3 should remain the same
    ]);
  }
}
