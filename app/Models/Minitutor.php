<?php

namespace App\Models;

use App\models\RequestArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

class Minitutor extends Model
{
    use Subscribable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * Get the user relation.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the playlists relation.
     */
    public function playlists() : HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Get the articles relation.
     */
    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the request playlists relation.
     */
    public function requestPlaylists() : HasMany
    {
        return $this->hasMany(RequestPlaylist::class);
    }

    /**
     * Get the request articles relation.
     */
    public function requestArticles() : HasMany
    {
        return $this->hasMany(RequestArticle::class);
    }
}
