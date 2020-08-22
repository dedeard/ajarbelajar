<?php

namespace App\Models;

use App\Helpers\AvatarHelper;
use App\Notifications\Auth\VerifyEmailNotification;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'email_verified_at',
        'name',
        'avatar',
        'about',
        'website_url',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'username',
        'email',
        'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function apiToken($forceUpdate = false)
    {
        $token = Str::random(100);
        if(!$this->api_token || $forceUpdate) {
            $this->timestamps = false;
            $this->forceFill(['api_token' => $token])->save();
            $this->timestamps = true;
        } else {
            $token = $this->api_token;
        }
        return $token;
    }

    public function clearApiToken()
    {
        $this->timestamps = false;
        $this->forceFill(['api_token' => null])->save();
        $this->timestamps = true;
    }

    public function minitutor()
    {
        return $this->hasOne(Minitutor::class);
    }

    public function avatarUrl($nulllable = false)
    {
        if($nulllable && !$this->avatar) {
            return null;
        }
        return AvatarHelper::getUrl($this->avatar);
    }

    public function sendMemberEmailVerify() : void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function generateRemeberPasswordToken() : string
    {
        return Password::broker()->createToken($this);
    }

    public function sendMemberEmailResetPassword() : void
    {
        $this->notify(new ResetPasswordNotification($this->generateRemeberPasswordToken()));
    }
}
