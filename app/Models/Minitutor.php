<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minitutor extends Model
{
    protected $fillable = [
        'user_id',
        'active',
        'last_education',
        'university',
        'city_and_country_of_study',
        'majors',
        'interest_talent',
        'contact',
        'expectation',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function requestPosts()
    {
        return $this->hasMany(RequestPost::class);
    }
}
