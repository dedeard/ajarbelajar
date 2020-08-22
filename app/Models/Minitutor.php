<?php

namespace App\Models;

use App\models\RequestArticle;
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
        return $this->hasMany(Playlist::class);
    }

    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function requestPlaylists() : HasMany
    {
        return $this->hasMany(RequestPlaylist::class);
    }

    public function requestArticles() : HasMany
    {
        return $this->hasMany(RequestArticle::class);
    }
}
