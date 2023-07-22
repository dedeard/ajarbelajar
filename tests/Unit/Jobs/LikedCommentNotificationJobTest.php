<?php

namespace Tests\Unit\Jobs;

use App\Events\CommentLikedEvent;
use App\Jobs\LikedCommentNotificationJob;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentLikedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LikedCommentNotificationJobTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_sends_comment_liked_notification_when_notification_not_exists()
  {
    // Create a comment and user instance for the event
    $comment = Comment::factory()->create();
    $user = User::factory()->create();

    // Mock the CommentLikedEvent with the comment and user instances
    $event = new CommentLikedEvent($comment, $user);

    // Mock the CommentLikedNotification
    Notification::fake();

    // Create the job instance
    $job = new LikedCommentNotificationJob();

    // Execute the job
    $job->handle($event);

    // Assertions
    Notification::assertSentTo(
      $comment->user,
      CommentLikedNotification::class,
      function ($notification) use ($comment, $user) {
        return $notification->comment->id === $comment->id && $notification->user->id === $user->id;
      }
    );
  }
}
