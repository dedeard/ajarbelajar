<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "episode_id" => $this->episode_id,
            "body" => $this->body,
            "html_body" => $this->html_body,
            "like_count" => $this->like_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'time_ago' => $this->created_at->diffForHumans(),
            'user' => $this->when($this->relationLoaded('user'), fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'avatar_url' => $this->user->avatar_url,
            ]),
            'liked' => $this->when($this->relationLoaded('likes'), fn () => count($this->likes) > 0, false)
        ];
    }
}
