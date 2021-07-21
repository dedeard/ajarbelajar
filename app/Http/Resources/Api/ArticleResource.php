<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    private function createDescription($json)
    {
        $description = null;
        $body = $json ? json_decode($json) : null;
        if(isset($body) && isset($body->blocks)) {
            foreach ($body->blocks as $block) {
                if(!$description && $block->type === 'paragraph' && strlen($block->data->text) > 30){
                    $description = substr($block->data->text, 0, 160);
                }
            }

            if(!$description) {
                foreach ($body->blocks as $block) {
                    if(!$description && $block->type === 'paragraph'){
                        $description = substr($block->data->text, 0, 160);
                    }
                }
            }
        }
        return $description;
    }
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
            'description' => $this->description ?? $this->createDescription($this->body),
            'body' => $this->body,
            'view_count' => $this->view_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'hero' => $this->hero_url,
            'category' => $this->category,
            'minitutor' => [
                'id' => $this->minitutor->id,
                'last_education' => $this->minitutor->last_education,
                'university' => $this->minitutor->university,
                'city_and_country_of_study' => $this->minitutor->city_and_country_of_study,
                'majors' => $this->minitutor->majors,
            ],
            'user' => [
                'name' => $this->minitutor->user->name,
                'avatar' => $this->minitutor->user->avatar_url,
                'username' => $this->minitutor->user->username,
                'points' => $this->minitutor->user->points,
                'about' => $this->minitutor->user->about,
                'website' => $this->minitutor->user->website,
            ],
            'comments' => CommentResource::collection($this->comments),
            'comments_count' => count($this->comments),
            'rating' => round($this->rating, 2),
            'feedback_count' => $this->feedback_count,
        ];
    }
}
