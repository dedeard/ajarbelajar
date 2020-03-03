<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'about',
        'website_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
