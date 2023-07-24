<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Comments;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test that the Comments component renders correctly.
   *
   * @return void
   */
  public function testComponentRenders()
  {
    // Create a user and an episode
    $user = User::factory()->create();
    $episode = Episode::factory()->create();

    // Livewire test: render the Comments component and pass the episode and user data
    Livewire::test(Comments::class, ['episode' => $episode, 'user' => $user])
      ->assertSee('BELUM ADA KOMENTAR') // Assert that the component contains the text "Comments"
      ->assertSet('episode', $episode) // Assert that the component's episode property is set correctly
      ->assertSet('user', $user); // Assert that the component's user property is set correctly
  }

  /**
   * Test that the mount method correctly loads comments for the episode.
   *
   * @return void
   */
  public function testMountMethodLoadsComments()
  {
    // Create a user and an episode with comments
    $user = User::factory()->create();
    $episode = Episode::factory()->create();
    Comment::factory()->count(5)->create(['episode_id' => $episode->id]);

    // Livewire test: render the Comments component and pass the episode and user data
    $component = Livewire::test(Comments::class, ['episode' => $episode, 'user' => $user]);
    $comments = $episode->comments()->with('user', 'likeCounter')->orderBy('created_at', 'desc')->get();
    $component->assertSet('comments', $comments); // Assert that the component's comments property is set correctly
  }
}
