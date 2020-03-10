<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Nagy\LaravelRating\Traits\Rate\CanRate;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, CanSubscribe, CanFavorite, CanRate;

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function apiToken()
    {
        $token = $this->api_token;
        if(!$token) {
            $token = Str::random(80);
            $this->timestamps = false;
            $this->forceFill([ 'api_token' => $token ])->save();
            $this->timestamps = true;
        }
        return $token;
    }

    public function name()
    {
        $profile = $this->profile;

        if ($profile) {
            if($profile->last_name){
                return $profile->first_name . ' ' . $profile->last_name;
            }
            return $profile->first_name;
        }
        return "";
    }

    public function imageUrl()
    {
        if($image = $this->image){
            return asset('storage/avatar/' . $image->name);
        }
        return asset('img/placeholder/avatar.png');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function socials()
    {
        return $this->hasOne(UserSocial::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function isAdmin()
    {
        return $this->admin ? true : false;
    }

    public function requestMinitutor()
    {
        return $this->hasOne(RequestMinitutor::class);
    }

    public function minitutor()
    {
        return $this->hasOne(Minitutor::class);
    }

    public function requestArticles()
    {
        return $this->hasMany(RequestArticle::class);
    }

    public function requestVideos()
    {
        return $this->hasMany(RequestVideo::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
    
    public function postComments()
    {
        return $this->hasManyThrough(PostComment::class, Post::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function articleCount()
    {
        return $this->posts()->where('draf', 0)->where('type', 'article')->count();
    }

    public function videoCount()
    {
        return $this->posts()->where('draf', 0)->where('type', 'video')->count();
    }
}
