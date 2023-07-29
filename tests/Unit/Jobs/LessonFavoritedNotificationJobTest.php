<?php

namespace Tests\Unit\Jobs;

use App\Events\LessonFavoritedEvent;
use App\Jobs\LessonFavoritedNotificationJob;
use App\Models\Lesson;
use App\Models\User;
use App\Notifications\LessonFavoritedNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LessonFavoritedNotificationJobTest extends TestCase
{
    public function testLessonFavoritedNotificationJob()
    {
        // Create a lesson and a user (you can use factories or other methods to create them)
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        $event = new LessonFavoritedEvent($lesson, $user);

        // Mock the CommentLikedNotification
        Notification::fake();

        // Create the job instance
        $job = new LessonFavoritedNotificationJob();

        // Execute the job
        $job->handle($event);

        // Assert that the notification has been sent correctly
        Notification::assertSentTo(
            $lesson->user,
            function (LessonFavoritedNotification $notification, $channels) use ($lesson, $user) {
                return $notification->lesson->id === $lesson->id && $notification->user->id === $user->id;
            }
        );
    }
}
