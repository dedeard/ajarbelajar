<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar_url,
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
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at->timestamp : null,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'favorites' => $this->favorite_ids,
            'followings' => $this->following_ids,
            'notifications' => NotificationResource::collection($this->notifications()->get()),
            $this->mergeWhen($this->minitutor && $this->minitutor->active, function(){
                return [
                    "minitutor" => [
                        'id' => $this->minitutor->id,
                        'active' => $this->minitutor->active,
                        'last_education' => $this->minitutor->last_education,
                        'university' => $this->minitutor->university,
                        'city_and_country_of_study' => $this->minitutor->city_and_country_of_study,
                        'majors' => $this->minitutor->majors,
                        'interest_talent' => $this->minitutor->interest_talent,
                        'contact' => $this->minitutor->contact,
                        'expectation' => $this->minitutor->expectation,
                        'reason' => $this->minitutor->reason,
                        'request_playlists' => RequestPlaylistResource::collection($this->minitutor->requestPlaylists),
                        'request_articles' => RequestArticleResource::collection($this->minitutor->requestArticles),
                        'feedback' => $this->minitutor->feedback,
                        'comments' => $this->minitutor->comments,
                        'created_at' => $this->minitutor->created_at->timestamp,
                        'updated_at' => $this->minitutor->updated_at->timestamp,
                    ]
                ];
            }),
        ];
    }
}
