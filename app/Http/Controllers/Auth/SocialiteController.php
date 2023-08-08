<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

/**
 * Controller for handling social authentication using Laravel Socialite.
 */
class SocialiteController extends Controller
{
    /**
     * Redirect the user to the authentication provider's authorization page.
     *
     * @param  string  $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the provider after successful authentication.
     *
     * @param  string  $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            // Get user information from the provider
            $providerUser = Socialite::driver($provider)->user();

            // Check if the provider provided a valid email
            if (!$providerUser->email) {
                throw new \Exception("Mohon maaf, penyedia $provider tidak memberikan alamat email yang valid.");
            }

            // Get or create user based on the provider's information
            $user = $this->getUserOrCreate($providerUser, $provider);

            // Log in the user and redirect to the home page
            auth()->login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            // Redirect back to the login page with an error message
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }

    /**
     * Get the user associated with the given provider user or create a new user if not found.
     *
     * @param  mixed  $providerUser
     * @param  string  $provider
     * @return User
     */
    private function getUserOrCreate($providerUser, $provider)
    {
        // Check if an account with the same provider ID exists
        $account = Account::where('provider', $provider)
            ->where('provider_id', $providerUser->id)
            ->with('user')
            ->first();

        if (!$account) {
            // Get or create a user based on the email from the provider
            $user = User::firstOrCreate(
                ['email' => $providerUser->email],
                [
                    'name' => $providerUser->name,
                    'email_verified_at' => data_get($providerUser, 'user.verified_email') ? now() : null,
                    'username' => $this->createUsername($providerUser->name),
                ]
            );

            // Create a new account associated with the user
            $account = new Account(['provider' => $provider, 'provider_id' => $providerUser->id]);
            $user->accounts()->save($account);
        }


        // If the user associated with the account has not verified their email,
        // send an email verification notification to the user.
        if (!$account->user->hasVerifiedEmail()) {
            $account->user->sendEmailVerificationNotification();
        }

        // Return the associated user
        return $account->user;
    }

    /**
     * Create a unique username based on the given name.
     *
     * @param  string  $name The name to create the username from.
     * @return string The generated username.
     */
    private function createUsername($name)
    {
        $usernameMaxLen = 15;
        $usernameMinLen = 6;

        $cleanedName = preg_replace('/[^a-zA-Z0-9]/', '', $name);

        if (strlen($cleanedName) < $usernameMinLen) {
            $cleanedName = str_pad($cleanedName, $usernameMinLen, '0', STR_PAD_RIGHT);
        } elseif (strlen($cleanedName) > $usernameMaxLen) {
            $cleanedName = substr($cleanedName, 0, $usernameMaxLen);
        }

        $baseUsername = strtolower($cleanedName);
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $newLength = $usernameMaxLen - strlen($counter);
            $shortenedBase = substr($baseUsername, 0, $newLength);
            $username = $shortenedBase . $counter;
            $counter++;
        }

        // Return the generated username
        return $username;
    }
}
