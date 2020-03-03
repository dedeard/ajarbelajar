<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestArticle extends Model
{
    protected $fillable = [
        'user_id',
        'requested_at',
        'category_id',
        'title',
        'hero',
        'description',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function heroUrl()
    {
        if($this->hero) {
            return asset('storage/article/request/hero/' . $this->hero);
        }
        return asset('img/placeholder/post-lg.jpg');
    }

    public function thumbUrl()
    {
        if($this->hero) {
            return asset('storage/article/request/hero/thumb/' . $this->hero);
        }
        return asset('img/placeholder/post-sm.jpg');
    }

    public function type()
    {
        return 'article';
    }
}
