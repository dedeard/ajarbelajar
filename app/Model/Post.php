<?php

namespace App\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;
use Nagy\LaravelRating\Traits\Rate\Rateable;
use Conner\Tagging\Taggable;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasSlug, CanBeFavorited, Rateable, Taggable;

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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videoLists()
    {
        return $this->morphMany(Video::class, 'videoable');
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

    public function allViewCount()
    {
        return $this->views()->count();
    }

    public function reviews()
    {
        return $this->hasMany(PostReview::class);
    }

    public function status()
    {
        return $this->draf ? 'Draf' : 'Public';
    }

    public function avgRating()
    {
        return round($this->reviews->avg('rating'), 2);
    }

    public function reviewCount()
    {
        return $this->reviews->count();
    }

    public static function articles($user = null)
    {
        $model_post = null;
        if ($user && $user->minitutor()) {
            $model_post = $user->posts();
        } else {
            $model_post = Post::query();
        }
        return self::postType($model_post, 'article', false);
    }

    public static function videos($user = null)
    {
        $model_post = null;
        if ($user && $user->minitutor()) {
            $model_post = $user->posts();
        } else {
            $model_post = Post::query();
        }
        return self::postType($model_post, 'video', false);
    }

    public static function posts($user = null)
    {
        $model_post = null;
        if ($user && $user->minitutor()) {
            $model_post = $user->posts();
        } else {
            $model_post = Post::query();
        }
        return self::postType($model_post, null, false);
    }

    public static function postType($model, $type = null, $draf = false)
    {
        $model->select(['id', 'category_id', 'posts.user_id', 'title', 'slug', 'hero', 'posts.created_at', 'type', 'draf', 'description' ]);
        if(isset($draf)) $model->where('draf', $draf);
        if($type) {
            if($type == 'article') {
                $model->where('type', 'article');
            } else if ($type == 'video') {
                $model->where('type', 'video');
            }
        }
        $model->with(['reviews' => function($q){
            return $q->select(['post_id', DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')]);
        }, 'user' => function($query){
            return $query->select(['id', 'username', 'first_name', 'last_name']);
        }]);
        $model->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'=> function($q){
            $q->select(DB::raw('count(distinct(ip))'));
        }]);
        return $model;
    }
}
