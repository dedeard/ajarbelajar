<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MinitutorsResource extends JsonResource
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
            'followers_count' => $this->followers_count ?? null,
            'playlists_count' => $this->playlists_count ?? null,
            'articles_count' => $this->articles_count ?? null,
            'created_at' => $this->created_at ? $this->created_at->timestamp : null,
            'updated_at' => $this->updated_at ? $this->updated_at->timestamp : null,
        ];
    }
}
