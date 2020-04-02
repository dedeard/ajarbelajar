<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Conner\Tagging\Taggable;

class RequestPost extends Model
{
    use Taggable;

    protected $fillable = [
        'user_id',
        'requested_at',
        'category_id',
        'title',
        'hero',
        'description',
        'type',
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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
