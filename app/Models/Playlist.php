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

class Playlist extends Model
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
        'view_count'
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
     * Get the videos relation.
     */
    public function videos() : MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
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
    public static function postListQuery($model, $draf = false)
    {
        $model
            ->select([
                'id',
                'minitutor_id',
                'category_id',
                'draf',
                'slug',
                'title',
                'view_count',
                'created_at',
                'updated_at',
                DB::raw("'Playlist' as type"),
            ])
            ->with(['hero', 'category'  => function($q){
                $q->select(['id', 'name', 'slug']);
            }])
            ->with(['minitutor' => function($q){
                $q->select(['id', 'user_id', 'active']);
                $q->with(['user' => function($q) {
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'points',
                        'username'
                    ]);
                }]);
            }])
            ->withCount(['comments' => function($query){
                return $query->where('public', true);
            }])
            ->withCount(['feedback as rating' => function($q){
                $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/4),0)'));
            }, 'feedback'])
            ->whereHas('minitutor', function($q){
                $q->where('active', true);
            });

            if(!$draf) {
                $model->where('draf', false);
            }
        return $model;
    }

    /**
     * Atributes
     */
    public function getHeroUrlAttribute() : Array
    {
        if($this->hero) {
            return HeroHelper::getUrl($this->hero->name);
        }
        $keyed = collect(HeroHelper::SIZES)->mapWithKeys(function($item, $key){
            return [$key => null];
        });
        return $keyed->all();
    }
}
