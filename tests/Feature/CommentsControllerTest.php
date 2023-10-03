<?php

namespace Tests\Feature;

use App\Events\CommentDeletedEvent;
use App\Events\CommentedEpisodeEvent;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test store method to create a new comment for an episode.
     *
     * @return void
     */
    public function testStore()
    {
        // Prevent the actual event from being dispatched during the test
        Event::fake();

        // Create a user and a public episode
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create(['public' => true]);
        $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);

        // Acting as the authenticated user
        $this->actingAs($user);

        // Send a POST request to store a new comment for the episode
        $body = json_encode([
            'blocks' => [
                [
                    'type' => 'paragraph', 'data' => ['text' => fake()->paragraph()],
                ],
            ],
        ]);
        $response = $this->post(route('comments.store', $episode->id), ['body' => $body]);

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that the comment is created in the database
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'episode_id' => $episode->id,
        ]);

        // Assert that the CommentedEpisodeEvent event is dispatched
        Event::assertDispatched(CommentedEpisodeEvent::class, function ($event) use ($user, $episode) {
            return $event->comment->user_id === $user->id &&
                $event->comment->episode_id === $episode->id;
        });
    }

    /**
     * Test destroy method to delete a comment.
     *
     * @return void
     */
    public function testDestroy()
    {
        // Prevent the actual event from being dispatched during the test
        Event::fake();

        // Create a user with a comment
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        // Acting as the authenticated user
        $this->actingAs($user);

        // Send a DELETE request to delete the comment
        $response = $this->delete(route('comments.destroy', ['comment' => $comment->id]));

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that the comment is no longer present in the database
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

        // Assert that the CommentDeletedEvent event is dispatched
        Event::assertDispatched(CommentDeletedEvent::class, function ($event) use ($comment) {
            return $event->comment['id'] === $comment->id;
        });
    }
}
