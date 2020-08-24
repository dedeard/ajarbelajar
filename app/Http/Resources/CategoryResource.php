<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'playlist_count' => $this->playlists()->where('draf', false)->count(),
            'article_count' => $this->articles()->where('draf', false)->count(),
            'slug' => $this->slug,
        ];
    }
}
