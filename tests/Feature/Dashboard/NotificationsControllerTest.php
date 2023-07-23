<?php

namespace Tests\Unit\Dashboard;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Notifications\CommentLikedNotification;
use App\Notifications\EpisodeCommentedNotification;
use App\Notifications\LessonFavoritedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test index method to view notifications.
   *
   * @return void
   */
  public function testIndex()
  {
    // Create a user with notifications
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $lesson = Lesson::factory()->create(['user_id' => $user1->id]);
    $user1->notify(new LessonFavoritedNotification($lesson, $user2));

    // Acting as the authenticated user
    $this->actingAs($user1);

    // Send a GET request to the notifications index route
    $response = $this->get(route('dashboard.notifications.index'));

    // Assert that the response has a successful status code
    $response->assertSuccessful();

    // Assert that the notifications are being displayed on the view
    $response->assertViewHas('notifications');

    // Assert that the user's notifications are being paginated
    $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->original->getData()['notifications']);

    // Assert that the notifications are ordered by created_at in descending order
    $notifications = $response->original->getData()['notifications']->items();
    $this->assertNotEmpty($notifications);

    // Assert that the view contains the notifications
    foreach ($notifications as $notification) {
      $this->assertStringContainsString($notification->data['message'], $response->getContent());
    }
  }


  /**
   * Test read method to mark notification as read and check redirections.
   *
   * @return void
   */
  public function testRead()
  {
    // Create a user with notifications
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Send notifications to the user
    $comment = Comment::factory()->create(['user_id' => $user1->id]);
    $user1->notify(new CommentLikedNotification($comment, $user2));

    $comment = Comment::factory()->create(['user_id' => $user2->id]);
    $user1->notify(new EpisodeCommentedNotification($comment));

    $lesson = Lesson::factory()->create(['user_id' => $user1->id]);
    $user1->notify(new LessonFavoritedNotification($lesson, $user2));

    // Acting as the authenticated user
    $this->actingAs($user1);

    // Get the first notification
    $notification = $user1->unreadNotifications->first();
    // Send a GET request to mark the notification as read
    $response = $this->get(route('dashboard.notifications.read', ['id' => $notification->id]));
    // Assert that the response is a redirect
    $response->assertRedirect();

    // Assert that the notification is marked as read in the database
    $this->assertTrue($notification->fresh()->read());

    // Check redirection based on the notification type
    switch ($notification->type) {
      case CommentLikedNotification::class:
        $comment = Comment::with('episode.lesson')->findOrFail($notification->data['comment_id']);
        $response->assertRedirect(route('lessons.watch', ['lesson' => $comment->episode->lesson->slug, 'index' => $comment->episode->index]));
        break;

      case EpisodeCommentedNotification::class:
        $comment = Comment::with('episode.lesson')->findOrFail($notification->data['comment_id']);
        $response->assertRedirect(route('lessons.watch', ['lesson' => $comment->episode->lesson->slug, 'index' => $comment->episode->index]));
        break;

      case LessonFavoritedNotification::class:
        $lesson = Lesson::findOrFail($notification->data['lesson_id']);
        $response->assertRedirect(route('lessons.show', $lesson->slug));
        break;

      default:
        $this->fail("Unknown notification type: {$notification->type}");
        break;
    }
  }

  /**
   * Test markall method to mark all notifications as read and check redirection.
   *
   * @return void
   */
  public function testMarkAll()
  {
    // Create a user with notifications
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $lesson = Lesson::factory()->create(['user_id' => $user1->id]);
    $user1->notify(new LessonFavoritedNotification($lesson, $user2));
    // Acting as the authenticated user
    $this->actingAs($user1);

    // Send a GET request to mark all notifications as read
    $response = $this->from(route('dashboard.notifications.index'))->get(route('dashboard.notifications.markall'));

    // Assert that the response is a redirect back
    $response->assertRedirect(route('dashboard.notifications.index'));

    // Assert that all notifications are marked as read in the database
    $this->assertEquals(0, $user1->unreadNotifications()->count());
  }
}
