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
            'avatar' => $this->avatarUrl(),
            'point' => $this->point,
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
            'minitutor' => MinitutorResource::make($this->minitutor)
        ];
    }
}
