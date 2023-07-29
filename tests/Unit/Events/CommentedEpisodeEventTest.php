<?php

namespace Tests\Unit\Events;

use App\Events\CommentedEpisodeEvent;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentedEpisodeEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_commented_episode_event_instance_with_comment()
    {
        // Create a sample comment
        $comment = Comment::factory()->create();

        // Trigger the CommentedEpisodeEvent
        $event = new CommentedEpisodeEvent($comment);

        // Assertions
        Event::fake(); // Fake the event dispatcher
        event($event); // Trigger the event
        Event::assertDispatched(CommentedEpisodeEvent::class, function ($e) use ($comment) {
            return $e->comment->id === $comment->id;
        });
    }
}
