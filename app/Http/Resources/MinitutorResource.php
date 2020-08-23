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
            'active' => $this->active,
            'last_education' => $this->last_education,
            'university' => $this->university,
            'city_and_country_of_study' => $this->city_and_country_of_study,
            'majors' => $this->majors,
            'interest_talent' => $this->interest_talent,
            'contact' => $this->contact,
            'expectation' => $this->expectation,
            'reason' => $this->reason,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'playlists' => PlaylistResource::collection($this->playlists),
            'articles' => ArticleResource::collection($this->articles),
            'request_playlists' => RequestPlaylistResorurce::collection($this->requestPlaylists),
            'request_articles' => RequestArticleResource::collection($this->requestArticles),
        ];
    }
}
