<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Minitutor;
use App\Models\Playlist;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $playlists = $this->subscriptions()->withType(Playlist::class)->get()->toArray();
        $articles = $this->subscriptions()->withType(Article::class)->get()->toArray();

        $favorites = [
            'playlists' => [],
            'articles' => [],
        ];

        foreach($playlists as $playlist){
            array_push($favorites['playlists'], $playlist['subscribable_id']);
        }
        foreach($articles as $article){
            array_push($favorites['articles'], $article['subscribable_id']);
        }

        $arr = $this->subscriptions()->withType(Minitutor::class)->whereHas('minitutor', function($q){
            $q->where('active', true);
        })->get()->toArray();

        $followings = [];
        foreach($arr as $following){
            array_push($followings, $following['subscribable_id']);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatarUrl(),
            'points' => $this->points,
            'about' => $this->about,
            'website_url' => $this->website_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'facebook_url' => $this->facebook_url,
            'github_url' => $this->github_url,
            'youtube_url' => $this->youtube_url,
            'username' => $this->username,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'minitutor' => MinitutorResource::make($this->minitutor),
            'favorites' => $favorites,
            'followings' => $followings,
        ];
    }
}
