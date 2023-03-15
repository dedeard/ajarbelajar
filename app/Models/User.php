<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function hasFavorited($lessonId): bool
    {
        return (bool) $this->favorites->firstWhere('lesson_id', $lessonId);
    }

    public function favoriteToggle($lessonId): bool
    {
        $favorite = $this->favorites->firstWhere('lesson_id', $lessonId);
        if (!$favorite) {
            $data = new Favorite(['lesson_id' => $lessonId]);
            $this->favorites()->save($data);
            return true;
        } else {
            $favorite->delete();
            return false;
        }
    }

    public function getAvatarUrlAttribute(): string
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($this->email)));
        return $url;
    }
}
