<?php

namespace Tests\Feature\Livewire;

use App\Events\LessonFavoritedEvent;
use App\Http\Livewire\FavoriteToggle;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class FavoriteToggleTest extends TestCase
{
  use RefreshDatabase;

  public function testUserCanFavoriteLesson()
  {
    Event::fake(); // Prevent the actual event from being dispatched during the test

    // Create a user and a lesson
    $user = User::factory()->create();
    $lesson = Lesson::factory()->create();
    $this->actingAs($user);
    // Livewire test: render the FavoriteToggle component and pass the lesson and user data
    Livewire::test(FavoriteToggle::class, ['lesson' => $lesson, 'user' => $user])
      ->assertSee('Favorite'); // The button should display 'Favorite' since the lesson is not yet favorited

    // Emit the onclick event to favorite the lesson
    Livewire::test(FavoriteToggle::class, ['lesson' => $lesson, 'user' => $user])
      ->call('onclick')
      ->assertSet('favorited', true);

    // Assert that the LessonFavoritedEvent event is dispatched
    Event::assertDispatched(LessonFavoritedEvent::class, function ($event) use ($lesson, $user) {
      return $event->lesson->id === $lesson->id && $event->user->id === $user->id;
    });
  }

  public function testGuestUserCannotFavoriteLesson()
  {
    // Create a lesson
    $lesson = Lesson::factory()->create();

    // Livewire test: render the FavoriteToggle component without passing a user (guest user)
    Livewire::test(FavoriteToggle::class, ['lesson' => $lesson])
      ->assertSet('favorited', false) // Assert that the favorited property remains false (guest user cannot favorite)
      ->call('onclick') // Emit the onclick event to attempt to favorite the lesson
      ->assertSet('favorited', false); // Assert that the favorited property remains false (guest user cannot favorite)
  }
}
