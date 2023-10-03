<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/settings')
            ->post('/settings/update-password', [
                'current_password' => 'password',
                'new_password' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/settings');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/settings')
            ->post('/settings/update-password', [
                'current_password' => 'wrong-password',
                'new_password' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrors('current_password')
            ->assertRedirect('settings');
    }

    public function testUpdateProfile()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        Storage::fake('public');

        $response = $this->actingAs($user)
            ->post(route('settings.update-profile'), [
                'name' => 'New Name',
                'username' => 'newusername',
                'bio' => 'New Bio',
                'website' => 'https://newwebsite.com',
                'avatar' => $file,
            ]);

        // Assert that user profile was updated.
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'username' => 'newusername',
            'bio' => 'New Bio',
            'website' => 'https://newwebsite.com',
        ]);

        // Assert a successful flash message...
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success',  'Profil berhasil diperbarui.');
    }
}
