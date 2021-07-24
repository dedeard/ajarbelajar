<?php

namespace App\Models;

use App\Helpers\MinitutorcvHelper;
use Illuminate\Database\Eloquent\Model;

class JoinMinitutor extends Model
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
        'cv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atributes
     */
    public function getCvUrlAttribute()
    {
        if(!$this->cv) {
            return null;
        }
        return MinitutorcvHelper::getUrl($this->cv);
    }
}
