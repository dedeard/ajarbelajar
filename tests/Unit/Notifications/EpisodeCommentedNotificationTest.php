<?php

namespace Tests\Unit\Notifications;

use App\Models\Comment;
use App\Notifications\EpisodeCommentedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EpisodeCommentedNotificationTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_creates_correct_notification_message()
  {
    // Create a comment
    $comment = Comment::factory()->create();

    // Create the notification
    $notification = new EpisodeCommentedNotification($comment);

    // Get the notification message data
    $data = $notification->toArray($comment->episode->lesson->user);

    // Assertions
    $this->assertArrayHasKey('comment_id', $data);
    $this->assertArrayHasKey('message', $data);
    $this->assertEquals($comment->id, $data['comment_id']);
    $this->assertEquals(
      $comment->user->name . " telah mengomentari video anda.",
      $data['message']
    );
  }

  /** @test */
  public function it_sends_notification_via_database_and_broadcast()
  {
    Notification::fake(); // Fake the notifications

    // Create a comment
    $comment = Comment::factory()->create();

    // Send the notification
    $comment->episode->lesson->user->notify(new EpisodeCommentedNotification($comment));

    // Assertions
    Notification::assertSentTo(
      $comment->episode->lesson->user,
      EpisodeCommentedNotification::class
    );
  }
}
