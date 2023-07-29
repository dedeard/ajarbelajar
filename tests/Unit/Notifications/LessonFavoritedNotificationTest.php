<?php

namespace Tests\Unit\Notifications;

use App\Models\Lesson;
use App\Models\User;
use App\Notifications\LessonFavoritedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LessonFavoritedNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testLessonFavoritedNotification()
    {
        // Create a lesson and a user (you can use factories or other methods to create them)
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        // Send the notification
        Notification::fake();
        $user->notify(new LessonFavoritedNotification($lesson, $user));

        // Assert the notification was sent to the database
        Notification::assertSentTo($user, LessonFavoritedNotification::class);
    }
}
