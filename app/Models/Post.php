<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use DB;

class Post extends Model
{
    use HasSlug;

    protected $fillable = [
        'minitutor_id',
        'category_id',
        'posted_at',
        'title',
        'slug',
        'description',
        'view_count',
        'hero',
        'type',
        'body',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function minitutor()
    {
        return $this->belongsTo(Minitutor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Atributes
     */
    public function getHeroUrlAttribute()
    {
        if($this->hero) {
            return HeroHelper::getUrl($this->hero);
        }
        $keyed = collect(HeroHelper::SIZES)->mapWithKeys(function($item, $key){
            return [$key => null];
        });
        return $keyed->all();
    }

    public function getVideoUrlAttribute()
    {
        if($this->body) {
            return VideoHelper::getUrl($this->body);
        }
        return null;
    }



    // Query
    public static function postListQuery($model, $publicOnly = true, $type = null)
    {
        $model
            ->select([
                'id',
                'minitutor_id',
                'category_id',
                'posted_at',
                'slug',
                'title',
                'hero',
                'type',
                'view_count',
                'created_at',
                'updated_at',
            ])
            ->with(['minitutor' => function ($q) {
                $q->select(['id', 'user_id', 'active']);
                $q->with(['user' => function ($q) {
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'points',
                        'username',
                    ]);
                }]);
            }])
            ->withCount(['comments' => function ($query) {
                return $query->where('public', true);
            }])
            ->withCount(['feedback as rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/4),0)'));
            }, 'feedback'])
            ->whereHas('minitutor', function ($q) {
                $q->where('active', true);
            });

        if($type) {
            $model->where('type', $type);
        }

        if ($publicOnly) {
            $model->whereNotNull('posted_at');
        }

        return $model;
    }
}
