<?php

namespace App\Models;

use App\Helpers\AvatarHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'avatar',
        'points',
        'about',
        'website',
        'username',
        'email',
        'password',
        'email_notification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function minitutor()
    {
        return $this->hasOne(Minitutor::class);
    }

    public function joinMinitutor()
    {
        return $this->hasOne(JoinMinitutor::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function followings()
    {
        return $this->hasMany(Follow::class);
    }

    public function incrementPoint($point) {
        $this->points = $this->points + $point;
        return $this->save();
    }

    /**
     * Atributes
     */
    public function getAvatarUrlAttribute()
    {
        if(!$this->avatar) {
            return 'https://ui-avatars.com/api/?bold=true&background=f0f2fc&color=677ae4&size=120&name=' . $this->name;
        }
        return AvatarHelper::getUrl($this->avatar);
    }
}
