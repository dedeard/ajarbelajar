<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test index method to view home page.
   *
   * @return void
   */
  public function testIndex()
  {
    // Create sample lessons, categories, and users
    $lessons = Lesson::factory()->count(3)->create(['public' => true]);
    $categories = Category::all(); // auto create when Lesson created
    $users = User::factory()->count(3)->create();

    // Send a GET request to the home index route
    $response = $this->get(route('home'));

    // Assert that the response is successful
    $response->assertSuccessful();

    // Assert that the view has the required variables
    $response->assertViewHas(['lessons', 'categories', 'users']);

    // Assert that the lessons, categories, and users are present in the view
    foreach ($lessons as $lesson) {
      $response->assertSee($lesson->title);
    }
    foreach ($categories as $category) {
      $response->assertSee($category->name);
    }
    foreach ($users as $user) {
      $response->assertSee($user->name);
    }
  }
}
