<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewUserLessonsCard;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewUserLessonsCardTest extends TestCase
{
  use RefreshDatabase;

  public function testNewUserLessonsCardRendersCorrectly()
  {
    // Create a user and lessons for the user
    $user = User::factory()->create();
    $lessons = Lesson::factory()->count(4)->create(['public' => true, 'user_id' => $user->id]);

    // Livewire test: render the NewUserLessonsCard component and pass the user and ignoreId data
    Livewire::test(NewUserLessonsCard::class, ['user' => $user, 'ignoreId' => $lessons[0]->id])
      ->assertDontSee($lessons[0]->title) // Assert that the component renders the title of the first lesson
      ->assertSee($lessons[1]->title) // Assert that the component renders the title of the second lesson
      ->assertSee($lessons[2]->title) // Assert that the component renders the title of the third lesson
      ->assertSee($lessons[3]->title); // Assert that the component renders the title of the fourth lesson
  }
}
