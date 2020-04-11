<?php

namespace App\Model;

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
        'join_group'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
