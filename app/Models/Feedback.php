<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'sync_with_me',
        'understand',
        'inspiring',
        'language_style',
        'content_flow',
        'message',
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Atributes
     */
    public function getRatingAttribute()
    {
        return ($this->understand + $this->inspiring + $this->language_style + $this->content_flow)/4;
    }
}
