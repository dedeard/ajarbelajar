<?php

namespace Tests\Unit\Notifications;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentLikedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentLikedNotificationTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_sends_database_and_broadcast_notifications()
  {
    // Create a comment and user instance for the notification
    $comment = Comment::factory()->create();
    $user = User::factory()->create();

    Notification::fake();

    // Send the notification
    $user->notify(new CommentLikedNotification($comment, $user));

    // Assertions
    Notification::assertSentTo(
      $user,
      CommentLikedNotification::class,
      function ($notification) use ($comment, $user) {
        return $notification->comment->id === $comment->id && $notification->user->id === $user->id;
      }
    );

    Notification::assertSentToTimes($user, CommentLikedNotification::class, 1);
  }

  /** @test */
  public function it_has_correct_notification_data()
  {
    // Create a comment and user instance for the notification
    $comment = Comment::factory()->create();
    $user = User::factory()->create();

    // Create the CommentLikedNotification instance
    $notification = new CommentLikedNotification($comment, $user);

    // Get the notification data
    $data = $notification->toArray(new AnonymousNotifiable());

    // Assertions
    $this->assertArrayHasKey('comment_id', $data);
    $this->assertEquals($comment->id, $data['comment_id']);
    $this->assertArrayHasKey('message', $data);
    $this->assertEquals($user->name . " menyukai komentar anda.", $data['message']);
    $this->assertArrayHasKey('user_id', $data);
    $this->assertEquals($user->id, $data['user_id']);
  }
}
