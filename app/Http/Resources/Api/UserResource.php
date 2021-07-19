<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'points' => $this->points,
            'about' => $this->about,
            'website' => $this->website,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'minitutor' => MinitutorResource::make($this->whenLoaded('minitutor')),
            'activities' => $this->listActivities,
            'favorites' => $this->favorites,
            'followings' => $this->followings,
        ];
    }
}
