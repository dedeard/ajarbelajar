<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeSubscribed;

class Minitutor extends Model
{
    use CanBeSubscribed;

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
        'reason',
        'cv'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }
}
