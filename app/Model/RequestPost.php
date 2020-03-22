<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestPost extends Model
{
    protected $fillable = [
        'user_id',
        'requested_at',
        'category_id',
        'title',
        'hero',
        'description',
        'type',
        'videos',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function heroUrl()
    {
        if($this->hero) {
            return asset('storage/post/hero/request/' . $this->hero);
        }
        return asset('img/placeholder/post-lg.jpg');
    }

    public function thumbUrl()
    {
        if($this->hero) {
            return asset('storage/post/hero/request/thumb/' . $this->hero);
        }
        return asset('img/placeholder/post-sm.jpg');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
