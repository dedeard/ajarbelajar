<?php

namespace Tests\Unit\Events;

use App\Events\CommentUnlikedEvent;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentUnlikedEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_event_instance_with_comment_and_user()
    {
        // Create a comment and user instance for the event
        $comment = Comment::factory()->create();
        $user = User::factory()->create();

        // Create the event instance
        $event = new CommentUnlikedEvent($comment, $user);

        // Assertions
        $this->assertInstanceOf(CommentUnlikedEvent::class, $event);
        $this->assertSame($comment, $event->comment);
        $this->assertSame($user, $event->user);
    }

    /** @test */
    public function it_has_broadcast_as_method_with_comment_id()
    {
        // Create a comment and user instance for the event
        $comment = Comment::factory()->create();
        $user = User::factory()->create();

        // Create the event instance
        $event = new CommentUnlikedEvent($comment, $user);

        // Assertions
        $this->assertEquals((string) $comment->id, $event->broadcastAs());
    }

    /** @test */
    public function it_has_broadcast_on_method_with_comment_updated_channel()
    {
        // Create a comment and user instance for the event
        $comment = Comment::factory()->create();
        $user = User::factory()->create();

        // Create the event instance
        $event = new CommentUnlikedEvent($comment, $user);

        // Assertions
        $this->assertInstanceOf(\Illuminate\Broadcasting\Channel::class, $event->broadcastOn());
        $this->assertEquals('Comment.Updated', $event->broadcastOn()->name);
    }
}
