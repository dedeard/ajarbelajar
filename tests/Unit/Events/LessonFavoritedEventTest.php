<?php

namespace Tests\Unit\Events;

use App\Events\LessonFavoritedEvent;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LessonFavoritedEventTest extends TestCase
{
    public function testLessonFavoritedEvent()
    {
        // Create a lesson and a user (you can use factories or other methods to create them)
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        // Assert that the event is dispatched with the correct data
        Event::fake();
        event(new LessonFavoritedEvent($lesson, $user));
        Event::assertDispatched(LessonFavoritedEvent::class, function ($event) use ($lesson, $user) {
            return $event->lesson->id === $lesson->id && $event->user->id === $user->id;
        });
    }
}
