<?php

namespace Tests\Feature\Livewire;

use App\Events\CommentLikedEvent;
use App\Events\CommentUnlikedEvent;
use App\Http\Livewire\CommentList;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class CommentListTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test that the likeToggle method toggles the comment's like status and broadcasts the appropriate event.
   *
   * @return void
   */
  public function testLikeToggle()
  {
    // Prevent the actual event from being dispatched during the test
    Event::fake();

    // Create a user and a comment
    $user = User::factory()->create();
    $comment = Comment::factory()->create();
    $this->actingAs($user);
    // Livewire test: render the CommentList component and pass the comment and user data
    Livewire::test(CommentList::class, ['comment' => $comment, 'user' => $user])
      ->call('likeToggle') // Call the likeToggle method
      ->assertSet('comment.liked', true); // Assert that the comment's liked status is now true

    // Assert that the CommentLikedEvent event is dispatched
    Event::assertDispatched(CommentLikedEvent::class, function ($event) use ($comment, $user) {
      return $event->comment->id === $comment->id && $event->user->id === $user->id;
    });

    // Livewire test: call the likeToggle method again to toggle the like status back
    Livewire::test(CommentList::class, ['comment' => $comment, 'user' => $user])
      ->call('likeToggle') // Call the likeToggle method again
      ->assertSet('comment.liked', false); // Assert that the comment's liked status is now false
    // Assert that the CommentUnlikedEvent event is dispatched
    Event::assertDispatched(CommentUnlikedEvent::class, function ($event) use ($comment, $user) {
      return $event->comment->id === $comment->id && $event->user->id === $user->id;
    });
  }

  /**
   * Test that the refresh method correctly refreshes the comment.
   *
   * @return void
   */
  public function testRefresh()
  {
    // Create a comment
    $comment = Comment::factory()->create();
    $user = User::factory()->create();

    // Livewire test: render the CommentList component and pass the comment data
    $component = Livewire::test(CommentList::class, ['comment' => $comment]);
    $component->assertSet('comment.likeCount', 0);
    $comment->like($user->id);
    $component->call('refresh'); // Call the refresh method
    $component->assertSet('comment.likeCount', 1);
  }
}
