<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditProfileControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testIndex()
  {
    $user = User::factory()->create();

    // Mock authenticated user
    $this->actingAs($user);

    // Define the route and call the controller method
    $response = $this->get(route('dashboard.edit-profile'));

    // Assert response status and view
    $response->assertStatus(200);
    $response->assertViewIs('dashboard.edit-profile');
  }

  public function testUpdateSuccess()
  {
    $user = User::factory()->create();

    // Mock authenticated user
    $this->actingAs($user);

    // Define the route and data for update
    $data = [
      'name' => $this->faker->name,
      'username' => $this->faker->userName,
      'bio' => $this->faker->sentence,
      'website' => $this->faker->url,
    ];
    $response = $this->put(route('dashboard.edit-profile'), $data);

    // Assert successful update
    $response->assertRedirect();
    $response->assertSessionHas('success', 'Profil berhasil diperbarui.');

    // Assert that the user's data has been updated in the database
    $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'name' => $data['name'],
      'username' => $data['username'],
      'bio' => $data['bio'],
      'website' => $data['website'],
    ]);
  }

  public function testUpdateValidationErrors()
  {
    $user = User::factory()->create();
    $existsUser = User::factory()->create();

    // Mock authenticated user
    $this->actingAs($user);

    // Define the route and data for update (with invalid data to trigger validation errors)
    $data = [
      'name' => '', // Name is required, so this should trigger a validation error
      'username' => $existsUser->username, // Duplicate username should trigger a validation error
      'bio' => str_repeat('a', 251), // Bio should have max 250 characters, this should trigger a validation error
      'website' => 'invalid_url', // Website should be a valid URL, this should trigger a validation error
    ];
    $response = $this->put(route('dashboard.edit-profile'), $data);

    // Assert validation errors
    $response->assertSessionHasErrors(['name', 'username', 'bio', 'website']);
  }
}
