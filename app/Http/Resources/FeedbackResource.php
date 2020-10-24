<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
            'sync_with_me' => $this->sync_with_me,
            'understand' => $this->understand,
            'inspiring' => $this->inspiring,
            'language_style' => $this->language_style,
            'content_flow' => $this->content_flow,
            'message' => $this->message,
            'rating' => $this->rating,
            'user' => UsersResource::make($this->user),
            'created_at' => $this->created_at->timestamp
        ];
    }
}
