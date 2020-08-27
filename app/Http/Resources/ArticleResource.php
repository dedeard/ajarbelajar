<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'body' => $this->body,
            'hero' => $this->heroUrl(),
            'draf' => $this->draf,
            'comments_count' => $this->comments_count,
            'views_count' => $this->views_count,
            'feedback_count' => $this->feedback_count,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];

        if ($this->feedback) {
            $data['rating'] = $this->feedback->avg('rating');
        }

        if($this->category) {
            $data['category'] = [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ];
        }

        if ($this->minitutor) {
            $data['minitutor'] = MinitutorResource::make($this->minitutor);
            if ($this->minitutor->user) {
                $data['user'] = UserResource::make($this->minitutor->user);
            }
        }

        return $data;
    }
}
