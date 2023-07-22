<?php

namespace Tests\Unit\Jobs;

use App\Events\CommentedEpisodeEvent;
use App\Jobs\CommentedEpisodeNotificationJob;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\User;
use App\Notifications\EpisodeCommentedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentedEpisodeNotificationJobTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_sends_notification_to_lesson_owner_when_commented()
  {
    Notification::fake(); // Fake the notifications

    // Create a user, lesson, episode, and comment
    $user = User::factory()->create();
    $lesson = Lesson::factory()->create(['user_id' => $user->id]);
    $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);
    $comment = Comment::factory()->create(['episode_id' => $episode->id]);

    // Create the CommentedEpisodeEvent instance
    $event = new CommentedEpisodeEvent($comment);

    // Dispatch the job
    $job = new CommentedEpisodeNotificationJob();
    $job->handle($event);

    // Assertions
    Notification::assertSentTo(
      $user,
      function (EpisodeCommentedNotification $notification, array $channels, $notifiable) use ($comment) {
        return $notification->comment->id === $comment->id &&
          $notifiable->getKey() === $notification->comment->episode->lesson->user->id;
      }
    );
  }
}
