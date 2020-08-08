<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReview extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'sync_with_me',
        'understand',
        'inspiring',
        'language_style',
        'content_flow',
        'message'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
