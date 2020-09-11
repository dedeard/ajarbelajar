<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MinitutorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $feedback_count = 0;
        $comments_count = 0;

        $data = $this->playlists()->withCount(['feedback', 'comments' => function($q){
                    $q->where('public', true);
                }])->get();
        foreach ($data as $value) {
            $feedback_count = $feedback_count + $value->feedback_count;
            $comments_count = $comments_count + $value->comments_count;
        }

        $data = $this->articles()->withCount(['feedback', 'comments' => function($q){
                    $q->where('public', true);
                }])->get();
        foreach ($data as $value) {
            $feedback_count = $feedback_count + $value->feedback_count;
            $comments_count = $comments_count + $value->comments_count;
        }

        return [
            'id' => $this->id,
            'active' => $this->active,
            'last_education' => $this->last_education,
            'university' => $this->university,
            'city_and_country_of_study' => $this->city_and_country_of_study,
            'majors' => $this->majors,
            'interest_talent' => $this->interest_talent,
            'contact' => $this->contact,
            'expectation' => $this->expectation,
            'reason' => $this->reason,
            'playlists_count' => $this->requestPlaylists()->count(),
            'articles_count' => $this->requestArticles()->count(),
            'feedback_count' => $feedback_count,
            'comments_count' => $comments_count,
            'created_at' => $this->created_at ? $this->created_at->timestamp : null,
            'updated_at' => $this->updated_at ? $this->updated_at->timestamp : null,
        ];
    }
}
