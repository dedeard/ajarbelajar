<?php

namespace App\Models;

use App\Helpers\AvatarHelper;
use App\Http\Resources\Api\MinitutorResource;
use App\Http\Resources\Api\PostResource;
use App\Http\Resources\Api\UserResource;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, Subscriber;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'points',
        'about',
        'website',
        'username',
        'email',
        'password',
        'email_notification',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the minitutor relation.
     */
    public function minitutor()
    {
        return $this->hasOne(Minitutor::class);
    }

    /**
     * Get the join-minitutor relation.
     */
    public function joinMinitutor()
    {
        return $this->hasOne(JoinMinitutor::class);
    }

    /**
     * Get the comments relation.
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the feedback relation.
     */
    public function feedback() : HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the activities relation.
     */
    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Increment user point.
     */
    public function incrementPoint($point) {
        $this->points = $this->points + $point;
        return $this->save();
    }

    /**
     * Return notification broadcast route.
     */
    public function receivesBroadcastNotificationsOn(): String
    {
        return 'App.User.'.$this->id;
    }


    /**
     * Atributes
     */
    public function getAvatarUrlAttribute()
    {
        if(!$this->avatar) {
            return 'https://ui-avatars.com/api/?bold=true&background=f0f2fc&color=677ae4&size=120&name=' . $this->name;
        }
        return AvatarHelper::getUrl($this->avatar);
    }

    public function getListActivitiesAttribute()
    {
        $playlists = $this->activities()->with(['playlist' => function($q){
            Playlist::postListQuery($q);
        }])->whereHas('playlist')->where('activitiable_type', Playlist::class)->get();
        $articles = $this->activities()->with(['article' => function($q){
            Article::postListQuery($q);
        }])->whereHas('article')->where('activitiable_type', Article::class)->get();

        return $articles->merge($playlists)->transform(function($item){
            if(isset($item->article)){
                $post = $item->article;
            } else {
                $post = $item->playlist;
            }
            return [
                'id' => $item->id,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'post' => PostResource::make($post),
            ];
        })->sortByDesc('updated_at')->values()->all();
    }

    public function getFollowingsAttribute()
    {
        return $this->subscriptions()
            ->withType(Minitutor::class)
            ->with(['minitutor' => function($q){
                $q->with('user');
            }])
            ->whereHas('minitutor', function($q){
                $q->where('active', true);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function($item){
                return [
                    'id' => $item->id,
                    'user' => UserResource::make($item->minitutor->user),
                    'minitutor' => MinitutorResource::make($item->minitutor),
                ];
            });
    }

    public function getFavoritesAttribute()
    {
        $playlists = $this->subscriptions()
            ->withType(Playlist::class)
            ->with(['playlist' => function($q){
                return Playlist::postListQuery($q);
            }])
            ->get();

        $articles = $this->subscriptions()
            ->withType(Article::class)
            ->with(['article' => function($q){
                return Article::postListQuery($q);
            }])
            ->get();

        return $playlists->merge($articles)->transform(function($item){
            if(isset($item->article)){
                $post = $item->article;
            } else {
                $post = $item->playlist;
            }
            return [
                'id' => $item->id,
                'created_at' => $item->created_at ? $item->created_at->timestamp : null,
                'updated_at' => $item->updated_at ? $item->updated_at->timestamp : null,
                'post' => PostResource::make($post),
            ];
        })->sortByDesc('created_at')->values()->all();
    }

    public function getActiveMinitutorAttribute()
    {
        return $this->minitutor()->where('active', true)->exists();
    }

    public function getFavoriteIdsAttribute()
    {
        $playlists = $this->subscriptions()
            ->withType(Playlist::class)
            ->get()
            ->transform(function($item) {
                return $item->subscribable_id;
            });

        $articles = $this->subscriptions()
            ->withType(Article::class)
            ->get()
            ->transform(function($item) {
                return $item->subscribable_id;
            });

        return [
            'playlists' => $playlists,
            'articles' => $articles,
        ];
    }

    public function getFollowingIdsAttribute()
    {
        return $this->subscriptions()
            ->withType(Minitutor::class)
            ->get()
            ->transform(function($item) {
                return $item->subscribable_id;
            });
    }
}
