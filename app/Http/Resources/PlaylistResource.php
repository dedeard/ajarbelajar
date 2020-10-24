<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description ?? '',
            'view_count' => $this->view_count,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'type' => $this->type,
            'hero' => $this->hero_url,
            'category' => CategoryResource::make($this->category),
            'minitutor' => MinitutorsResource::make($this->minitutor),
            'user' => UsersResource::make($this->minitutor->user),
            'videos' => VideoResource::collection($this->videos),
            'comments' => CommentResource::collection($this->comments),
            'comments_count' => count($this->comments),
            'rating' => round($this->rating, 2),
            'feedback_count' => $this->feedback_count,
        ];
    }
}
