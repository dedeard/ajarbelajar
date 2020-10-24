<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class RequestPlaylist extends Model
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
        'description'
    ];

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
     * Get the hero relation.
     */
    public function hero() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
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
