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
            "apiToken" => $this->apiToken(),
            'name' => $this->name,
            'avatar' => $this->avatarUrl(),
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'minitutor' => MinitutorResource::make($this->minitutor)
        ];
    }
}
