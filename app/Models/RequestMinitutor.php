<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestMinitutor extends Model
{
    protected $fillable = [
        'user_id',
        'last_education',
        'university',
        'city_and_country_of_study',
        'majors',
        'interest_talent',
        'contact',
        'reason',
        'expectation',
        'join_group',
        'cv',
        'video'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
