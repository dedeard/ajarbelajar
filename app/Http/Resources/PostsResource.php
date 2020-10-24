<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
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
            'view_count' => $this->view_count,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
            'type' => $this->type,
            'hero' => $this->hero_url,
            'category' => CategoryResource::make($this->category),
            'user' => UsersResource::make($this->minitutor->user),
            'comments_count' => $this->comments_count,
            'rating' => round($this->rating, 2),
            'feedback_count' => $this->feedback_count,
        ];
    }
}
