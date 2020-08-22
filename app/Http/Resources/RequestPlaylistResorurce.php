<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestPlaylistResorurce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $videos = [];

        foreach($this->videos()->orderBy('index', 'asc')->get() as $video) {
            array_push($videos, [
                'id' => $video['id'],
                'index' => $video['index'],
                'url' => $video->getUrl(),
            ]);
        }

        $category = null;
        if($this->category) {
            $category = [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'hero' => $this->heroUrl(),
            'requested_at' => $this->requested_at ? Carbon::parse($this->requested_at)->timestamp : null,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'category' => $category,
            'videos' => $videos
        ];
    }
}
