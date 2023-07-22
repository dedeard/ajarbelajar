<?php

namespace Tests\Feature\Dashboard;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testIndex()
  {
    // Create a user and some favorite lessons
    $user = User::factory()->create();
    $favorites = Favorite::factory()->count(10)->create(['user_id' => $user->id]);

    // Define the route and call the controller method
    $response = $this->actingAs($user)->get('/dashboard/favorites');

    // Assert response status and view
    $response->assertStatus(200);
    $response->assertViewIs('dashboard.favorites');

    // Assert that the favorites data is available in the view
    $response->assertViewHas('favorites', function ($viewFavorites) use ($favorites) {
      return $favorites->pluck('id')->diff($viewFavorites->pluck('id'))->isEmpty();
    });
  }
}
