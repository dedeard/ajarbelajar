<?php

namespace App\models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class RequestArticle extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'requested_at',
        'title',
        'description',
        'body',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requested_at' => 'datetime'
    ];

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
     * Atributes
     */
    public function getHeroUrlAttribute() : Array
    {
        return HeroHelper::getUrl($this->hero ? $this->hero->name : null);
    }
}
