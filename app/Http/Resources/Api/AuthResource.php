<?php

namespace App\Http\Resources\Api;

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
            'website' => $this->website,
            'username' => $this->username,
            'email' => $this->email,
            'email_notification' => $this->email_notification ? true : false,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'favorites' => $this->favorite_ids,
            'followings' => $this->following_ids
        ];
    }
}
