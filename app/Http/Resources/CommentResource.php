<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'public' => $this->public,
            'body' => $this->body,
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at->timestamp
        ];

        if($this->user->minitutor) {
            $data['minituor'] = MinitutorResource::make($this->user->minitutor);
        }

        return $data;
    }
}
