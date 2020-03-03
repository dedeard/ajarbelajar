<?php

namespace App\Http\Resources;

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
        $user = [];

        $user['account'] = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at->format('Y/m/d'),
            'created_at' => $this->created_at->format('Y/m/d'),
            'updated_at' => $this->updated_at->format('Y/m/d'),
        ];
        $user['profile'] = [
            'first_name' => $this->profile ? $this->profile->first_name : '',
            'last_name' => $this->profile ? $this->profile->last_name : '',
            'about' => $this->profile ? $this->profile->about : '',
            'website' => $this->profile ? $this->profile->website : ''
        ];
        $user['socials'] = [
            'facebook' => $this->socials ? $this->socials->facebook : '',
            'instagram' => $this->socials ? $this->socials->instagram : '',
            'twitter' => $this->socials ? $this->socials->twitter : '',
            'github' => $this->socials ? $this->socials->github : '',
            'youtube' => $this->socials ? $this->socials->youtube : '',
        ];
        $user['admin'] = $this->admin ? true : false;
        $user['image'] = $this->imageUrl();

        return $user;
    }
}
