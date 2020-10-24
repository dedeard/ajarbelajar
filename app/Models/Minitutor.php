<?php

namespace App\Models;

use App\Http\Resources\CommentResource;
use App\Http\Resources\FeedbackResource;
use App\models\RequestArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
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

    /**
     * Get the minitutor lates posts.
     */
    public function latesPosts()
    {
        return $this->playlists()
        ->select(['minitutor_id', 'id', 'title', 'slug', 'draf', 'created_at', DB::raw("'Playlist' as type")])
        ->where('draf', false)
        ->unionAll(
            $this->articles()
                    ->select(['minitutor_id', 'id', 'title', 'slug', 'draf', 'created_at', DB::raw("'Article' as type")])
                    ->where('draf', false)
        )
        ->orderBy('created_at', 'desc');
    }

    public function getCommentsAttribute()
    {
        $commentQuery = function($query) {
            $query->with('user')->where('public', true);
        };
        $union = $this->playlists()->select('id')->with(['comments' => $commentQuery]);
        $comments = $this->articles()->select('id')->with(['comments' => $commentQuery])->union($union)->get()->pluck('comments')->flatten()->unique();
        return CommentResource::collection($comments);
    }

    public function getFeedbackAttribute()
    {
        $union = $this->playlists()->select('id')->with('feedback');
        $feedback = $this->articles()->select('id')->with('feedback')->union($union)->get()->pluck('feedback')->flatten()->unique();
        return FeedbackResource::collection($feedback);
    }
}
