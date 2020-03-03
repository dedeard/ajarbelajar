<?php

namespace App\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;
use Nagy\LaravelRating\Traits\Rate\Rateable;

class Article extends Model
{
    use HasSlug, CanBeFavorited, Rateable;

    protected $fillable = [
        'user_id',
        'draf',
        'category_id',
        'slug',
        'hero',
        'title',
        'description',
        'body'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function heroUrl()
    {
        if($this->hero) {
            return asset('storage/article/hero/' . $this->hero);
        }
        return asset('img/placeholder/post-lg.jpg');
    }

    public function thumbUrl()
    {
        if($this->hero) {
            return asset('storage/article/hero/thumb/' . $this->hero);
        }
        return asset('img/placeholder/post-sm.jpg');
    }

    public function type()
    {
        return 'article';
    }

    public function status()
    {
        return $this->draf ? 'Draf' : 'Publik';
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function views()
    {
        return $this->morphMany(PostView::class, 'viewable');
    }
}
