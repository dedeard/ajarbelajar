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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * Get and create the api token.
     */
    public function apiToken($forceUpdate = false) : string
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

    /**
     * Delete the api token.
     */
    public function clearApiToken() : void
    {
        $this->timestamps = false;
        $this->forceFill(['api_token' => null])->save();
        $this->timestamps = true;
    }

    /**
     * Get the minitutor relation.
     */
    public function minitutor()
    {
        return $this->hasOne(Minitutor::class);
    }

    /**
     * Return the hero url or placeholder url.
     */
    public function avatarUrl($nulllable = false)
    {
        if($nulllable && !$this->avatar) {
            return null;
        }
        return AvatarHelper::getUrl($this->avatar);
    }

    /**
     * Send email verification.
     */
    public function sendMemberEmailVerify() : void
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Generate remember password token code.
     */
    public function generateRemeberPasswordToken() : string
    {
        return Password::broker()->createToken($this);
    }

    /**
     * Send email forget password.
     */
    public function sendMemberEmailResetPassword() : void
    {
        $this->notify(new ResetPasswordNotification($this->generateRemeberPasswordToken()));
    }
}
