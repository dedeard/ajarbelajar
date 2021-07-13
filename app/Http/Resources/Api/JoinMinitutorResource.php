<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class JoinMinitutorResource extends JsonResource
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
            'last_education' => $this->last_education,
            'university' => $this->university,
            'city_and_country_of_study' => $this->city_and_country_of_study,
            'majors' => $this->majors,
            'interest_talent' => $this->interest_talent,
            'contact' => $this->contact,
            'reason' => $this->reason,
            'expectation' => $this->expectation,
            'cv' => $this->cvUrl,
            'created_at' => $this->created_at ? $this->created_at->timestamp : null,
            'updated_at' => $this->updated_at ? $this->updated_at->timestamp : null,
        ];
    }
}
