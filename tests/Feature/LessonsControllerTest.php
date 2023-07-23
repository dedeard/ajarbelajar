<?php

namespace Tests\Feature;

use App\Events\EpisodeWatchedEvent;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LessonsControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test index method to display a listing of lessons.
   *
   * @return void
   */
  public function testIndex()
  {
    // Create some sample lessons in the database
    Lesson::factory()->count(10)->create(['public' => true]);

    // Send a GET request to the lessons index route
    $response = $this->get(route('lessons.index'));

    // Assert that the response is successful
    $response->assertSuccessful();

    // Assert that the view has the 'lessons' and 'sort' variables
    $response->assertViewHas(['lessons', 'sort']);

    // Assert that the lessons are displayed on the view
    $lessons = Lesson::paginate(12);
    foreach ($lessons as $lesson) {
      $response->assertSee($lesson->title);
    }
  }

  /**
   * Test show method to display the specified lesson.
   *
   * @return void
   */
  public function testShow()
  {
    // Create a sample lesson in the database
    $lesson = Lesson::factory()->create(['public' => true]);

    // Send a GET request to the lessons show route
    $response = $this->get(route('lessons.show', $lesson->slug));

    // Assert that the response is successful
    $response->assertSuccessful();

    // Assert that the view has the 'lesson' variable
    $response->assertViewHas('lesson');

    // Assert that the lesson details are displayed on the view
    $response->assertSee($lesson->title);
  }

  /**
   * Test watch method to display the specified lesson and episode for watching.
   *
   * @return void
   */
  public function testWatch()
  {
    // Prevent the actual event from being dispatched during the test
    Event::fake();

    // Create a user, lesson, and episode
    $user = User::factory()->create();
    $lesson = Lesson::factory()->create(['public' => true]);
    $episode = Episode::factory()->create(['lesson_id' => $lesson->id]);

    // Acting as the authenticated user
    $this->actingAs($user);

    // Send a GET request to watch the episode
    $response = $this->get(route('lessons.watch', ['lesson' => $lesson->slug, 'index' => $episode->index]));

    // Assert that the response is successful
    $response->assertSuccessful();

    // Assert that the EpisodeWatched event is dispatched with the correct parameters
    Event::assertDispatched(EpisodeWatchedEvent::class, function ($event) use ($episode, $user) {
      return $event->episode->id === $episode->id && $event->user->id === $user->id;
    });
  }
}
