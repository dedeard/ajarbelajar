<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
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
        'website',
        'bio',
        'email_verified_at',
        'avatar_url',
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

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('username', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
        });
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function hasFavorited($lessonId): bool
    {
        return (bool) $this->favorites->firstWhere('lesson_id', $lessonId);
    }

    public function generateAvatar($image)
    {
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            $resizedImage = Image::make($image)->fit(config('image.avatar.size'), config('image.avatar.size'), function ($constraint) {
                $constraint->aspectRatio();
            });
            $name = config('image.avatar.directory') . Str::uuid() . config('image.avatar.extension');
            Storage::put($name, (string) $resizedImage->encode(config('image.avatar.format'), config('image.avatar.quality')));

            $this->avatar_url = Storage::url($name);
        } else {
            $this->avatar_url = $image;
        }
        $this->save();
    }
}
