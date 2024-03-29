<?php

namespace Tests\Unit\Events;

use App\Events\CommentDeletedEvent;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentDeletedEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_comment_deleted_event_instance_with_comment_data()
    {
        // Create a sample comment data
        $comment = Comment::factory()->create()->toArray();

        // Trigger the CommentDeletedEvent event
        $event = new CommentDeletedEvent($comment);

        // Assertions
        Event::fake(); // Fake the event dispatcher
        event($event); // Trigger the event
        Event::assertDispatched(CommentDeletedEvent::class, function ($e) use ($comment) {
            return $e->comment === $comment;
        });
    }
}
