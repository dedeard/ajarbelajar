<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        $prefix = config('frontend.url') . config('frontend.email_verify_url');
        $temporarySignedURL = URL::temporarySignedRoute(
            'api.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey()
            ]
        );
        return $prefix . urlencode($temporarySignedURL);
    }
}
