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
        'reason',
        'cv'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
