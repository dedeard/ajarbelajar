<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    protected $fillable = [
        'user_id',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
