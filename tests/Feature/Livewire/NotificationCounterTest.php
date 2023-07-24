<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NotificationCounter;
use App\Models\Lesson;
use App\Models\User;
use App\Notifications\LessonFavoritedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationCounterTest extends TestCase
{
  use RefreshDatabase;

  public function testNotificationCounterUpdatesOnMount()
  {
    // Prevent the actual event from being dispatched during the test
    Event::fake();

    // Create a user with unread notifications
    $user = User::factory()->create();
    $unreadNotificationCount = 3;
    $user->notify(new LessonFavoritedNotification(Lesson::factory()->create(['user_id' => $user->id]), $user));
    $user->notify(new LessonFavoritedNotification(Lesson::factory()->create(['user_id' => $user->id]), $user));
    $user->notify(new LessonFavoritedNotification(Lesson::factory()->create(['user_id' => $user->id]), $user));

    // Livewire test: render the NotificationCounter component and pass the user data
    Livewire::test(NotificationCounter::class, ['user' => $user])
      ->assertSet('count', $unreadNotificationCount);
  }

  public function testNotificationCounterUpdatesOnNotificationCreatedEvent()
  {
    // Prevent the actual event from being dispatched during the test
    Event::fake();

    // Create a user with no unread notifications
    $user = User::factory()->create();

    // Livewire test: render the NotificationCounter component and pass the user data
    $component = Livewire::test(NotificationCounter::class, ['user' => $user, 'count' => 0])
      ->assertSet('count', 0);

    $user->notify(new LessonFavoritedNotification(Lesson::factory()->create(['user_id' => $user->id]), $user));
    $component->emit("echo-private:App.Models.User.{$user->id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated");
    $component->assertSet('count', 1);
  }
}
