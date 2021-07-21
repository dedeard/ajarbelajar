<?php

namespace App\Http\Resources\Api;

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'hero' => $this->hero_url,
            'comments_count' => $this->comments_count,
            'rating' => round($this->rating, 2),
            'feedback_count' => $this->feedback_count,
            'category' => $this->category,
            'user' => [
                'username' => $this->minitutor->user->username,
                'name' => $this->minitutor->user->name,
                'avatar' => $this->minitutor->user->avatar_url,
                'points' => $this->minitutor->user->points,
            ],
        ];
    }
}
