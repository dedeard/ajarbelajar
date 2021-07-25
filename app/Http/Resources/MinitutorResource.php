<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MinitutorResource extends JsonResource
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
            'active' => $this->active,
            'last_education' => $this->last_education,
            'university' => $this->university,
            'city_and_country_of_study' => $this->city_and_country_of_study,
            'majors' => $this->majors,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
