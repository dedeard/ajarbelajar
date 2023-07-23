<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test index method to view a paginated list of users.
   *
   * @return void
   */
  public function testIndex()
  {
    // Create users
    User::factory()->count(30)->create();

    // Send a GET request to the users index route
    $response = $this->get(route('users.index'));

    // Assert that the response has a successful status code
    $response->assertSuccessful();

    // Assert that the users are being displayed on the view
    $response->assertViewHas('users');

    // Assert that the users are being paginated
    $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->original->getData()['users']);
  }

  /**
   * Test show method to view a user's lessons.
   *
   * @return void
   */
  public function testShow()
  {
    // Create a user and their lessons
    $user = User::factory()->create();
    Lesson::factory()->count(10)->create(['user_id' => $user->id]);

    // Test sorting by newest (default)
    $byDefault = $this->get(route('users.show', ['user' => $user->username]));
    $byDefault->assertSuccessful();
    $byDefault->assertViewHas('lessons');
    $byDefault->assertViewHas('sort', null);

    // Test sorting by oldest
    $byOldest = $this->get(route('users.show', ['user' => $user->username, 'sort' => 'oldest']));
    $byOldest->assertSuccessful();
    $byOldest->assertViewHas('lessons');
    $byOldest->assertViewHas('sort', 'oldest');

    // Test sorting by popularity
    // Note: You may need to add 'favorites' and 'favorite_count' relationship to the Lesson model for this test.
    $byPopularity = $this->get(route('users.show', ['user' => $user->username, 'sort' => 'popularity']));
    $byPopularity->assertSuccessful();
    $byPopularity->assertViewHas('lessons');
    $byPopularity->assertViewHas('sort', 'popularity');
  }
}
