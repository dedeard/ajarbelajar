<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasSlug;

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
    public static function generateQuery($model, $draf = false, $minitutor = true)
    {
        $model->select([
            'id',
            'minitutor_id',
            'category_id',
            'slug',
            'title',
            'draf',
            'description',
            'body',
            'created_at',
            'updated_at',
        ]);

        if($draf) {
            $model->where('draf', $draf);
        }

        $feedback = function($q) {
            return $q->select([
                'id',
                'feedbackable_type',
                'feedbackable_id',
                DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')
            ]);
        };

        $model->with(['feedback' => $feedback, 'hero', 'category']);

        if($minitutor) {
            $model->with(['minitutor' => function($q) {
                $q->select(['id', 'user_id'])
                ->with(['user' => function($q) {
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'point',
                        'website_url',
                        'twitter_url',
                        'facebook_url',
                        'instagram_url',
                        'youtube_url',
                        'username',
                    ]);
                }]);
            }]);
        }

        $model->withCount(['comments' => function($query){
            return $query->where('public', true);
        }, 'views'=> function($q){
            $q->select(DB::raw('count(distinct(ip))'));
        }, 'feedback']);

        return $model;
    }
}
