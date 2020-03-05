<?php

namespace App\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;
use Nagy\LaravelRating\Traits\Rate\Rateable;

class Post extends Model
{
    use HasSlug, CanBeFavorited, Rateable;

    protected $fillable = [
        'user_id',
        'draf',
        'type',
        'videos',
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
            return asset('storage/post/hero/' . $this->hero);
        }
        return asset('img/placeholder/post-lg.jpg');
    }

    public function thumbUrl()
    {
        if($this->hero) {
            return asset('storage/post/hero/thumb/' . $this->hero);
        }
        return asset('img/placeholder/post-sm.jpg');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    public function status()
    {
        return $this->draf ? 'Draf' : 'Public';
    }
}
