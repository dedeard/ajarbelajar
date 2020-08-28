<?php

namespace App\Models;

use App\Helpers\AvatarHelper;
use App\Notifications\Auth\VerifyEmailNotification;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, Subscriber, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_verified_at',
        'name',
        'avatar',
        'point',
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
     * Get the minitutor relation.
     */
    public function minitutor()
    {
        return $this->hasOne(Minitutor::class);
    }

    /**
     * Return the avatar url or placeholder url.
     */
    public function avatarUrl($nulllable = false)
    {
        if($nulllable && !$this->avatar) {
            return null;
        }
        return AvatarHelper::getUrl($this->avatar);
    }

    /**
     * Get the comments relation.
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the feedback relation.
     */
    public function feedback() : HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the views relation.
     */
    public function views() : HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * Get the activities relation.
     */
    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class);
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
