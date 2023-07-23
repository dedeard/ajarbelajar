<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test index method to redirect to activities when user is logged in and verified.
   *
   * @return void
   */
  public function testIndexRedirectLoggedInVerifiedUser()
  {
    // Create a user
    $user = User::factory()->create(['email_verified_at' => now()]);

    // Acting as the authenticated user
    $this->actingAs($user);

    // Send a GET request to the dashboard route
    $response = $this->get(route('dashboard'));

    // Assert that the response is a redirect
    $response->assertRedirect(route('dashboard.activities'));
  }

  /**
   * Test index method to redirect to login page when user is not logged in.
   *
   * @return void
   */
  public function testIndexRedirectUnauthenticatedUser()
  {
    // Send a GET request to the dashboard route without authentication
    $response = $this->get(route('dashboard'));

    // Assert that the response is a redirect to the login page
    $response->assertRedirect(route('login'));
  }

  /**
   * Test index method to redirect to verification page when user is not verified.
   *
   * @return void
   */
  public function testIndexRedirectUnverifiedUser()
  {
    // Create a user without email verification
    $user = User::factory()->create(['email_verified_at' => null]);

    // Acting as the authenticated user
    $this->actingAs($user);

    // Send a GET request to the dashboard route
    $response = $this->get(route('dashboard'));

    // Assert that the response is a redirect to the email verification page
    $response->assertRedirect(route('verification.notice'));
  }
}
