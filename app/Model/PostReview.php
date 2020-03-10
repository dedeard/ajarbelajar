<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostReview extends Model
{
    protected $fillable = [ 'body', 'user_id', 'post_id', 'rating' ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
