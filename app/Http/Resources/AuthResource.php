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
        $minitutor = null;
        if($this->minitutor) {
            $minitutor = [
                'active' => $this->minitutor->active,
                'last_education' => $this->minitutor->last_education,
                'university' => $this->minitutor->university,
                'city_and_country_of_study' => $this->minitutor->city_and_country_of_study,
                'majors' => $this->minitutor->majors,
                'interest_talent' => $this->minitutor->interest_talent,
                'contact' => $this->minitutor->contact,
                'expectation' => $this->minitutor->expectation,
                'reason' => $this->minitutor->reason,
            ];
        }
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
            'minitutor' => $minitutor
        ];
    }
}
