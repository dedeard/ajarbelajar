<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'type' => $this->type,
            'hero' => $this->hero_url,
            'view_count' => $this->view_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments_count' => $this->comments_count,
            'rating' => round($this->rating, 2),
            'feedback_count' => $this->feedback_count,
            'category' => [
                'id' => $this->category->id,
                'slug' => $this->category->slug,
                'name' => $this->category->name,
            ],
            'user' => [
                'id' => $this->minitutor->user->id,
                'name' => $this->minitutor->user->name,
                'avatar' => $this->minitutor->user->avatar_url,
                'username' => $this->minitutor->user->username,
                'points' => $this->minitutor->user->points,
            ]
        ];
    }
}
