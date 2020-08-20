<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function playlists() : HasMany
    {
        return $this->hasMany(Video::class);
    }
}
