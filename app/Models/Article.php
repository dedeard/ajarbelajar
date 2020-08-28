<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasSlug, Subscribable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'draf',
        'title',
        'slug',
        'description',
        'body'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the minitutor relation.
     */
    public function minitutor() : BelongsTo
    {
        return $this->belongsTo(Minitutor::class);
    }

    /**
     * Get the images relation.
     */
    public function images() : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'image');
    }

    /**
     * Get the comments relation.
     */
    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the feedback relation.
     */
    public function feedback() : MorphMany
    {
        return $this->morphMany(Feedback::class, 'feedbackable');
    }

    /**
     * Get the views relation.
     */
    public function views() : MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * Get the activities relation.
     */
    public function activities() : MorphMany
    {
        return $this->morphMany(Activity::class, 'activitiable');
    }

    /**
     * Get the hero relation.
     */
    public function hero() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'hero');
    }

    /**
     * Get the category relation.
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the hero url or placeholder url lists.
     */
    public function heroUrl() : Array
    {
        return HeroHelper::getUrl($this->hero ? $this->hero->name : null);
    }

    /**
     * Return the generated query.
     */
    public static function generateQuery($model, $all = false)
    {
        if(!$all) {
            $model->select([
                'id',
                'minitutor_id',
                'category_id',
                'slug',
                'title',
                'draf',
                'created_at',
                'updated_at',
            ]);
        }

        $model->where('draf', false);
        $model->with(['hero', 'category' => function($q){
            $q->select(['id', 'name', 'slug']);
        }]);
        $model->with(['minitutor' => function($q) use ($all){
            if(!$all) {
                $q->select(['id', 'user_id', 'active']);
            }
            $q->with(['user' => function($q) use ($all) {
                if(!$all) {
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'point',
                        'username',
                    ]);
                } else {
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'point',
                        'about',
                        'website_url',
                        'twitter_url',
                        'facebook_url',
                        'instagram_url',
                        'youtube_url',
                        'username',
                    ]);
                }
            }]);
        }]);

        if($all) {
            $model->with(['comments' => function($query){
                return $query->with(['user' => function($q){
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'point',
                        'username',
                    ]);
                }])->where('public', true);
            }]);
        } else {
            $model->withCount(['comments' => function($query){
                return $query->where('public', true);
            }]);
        }

        $model->withCount(['views'=> function($q){
            $q->select(DB::raw('count(distinct(ip))'));
        }, 'feedback as rating' => function($q){
            $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/5),0)'));
        }, 'feedback']);

        $model->whereHas('minitutor', function($q){
            $q->where('active', true);
        });

        return $model;
    }
}
