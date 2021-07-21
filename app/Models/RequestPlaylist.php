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
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requested_at' => 'datetime',
    ];

    /**
     * Get the minitutor relation.
     */
    public function minitutor(): BelongsTo
    {
        return $this->belongsTo(Minitutor::class);
    }

    /**
     * Get the videos relation.
     */
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    /**
     * Get the hero relation.
     */
    public function hero(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get the category relation.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Atributes
     */
    public function getHeroUrlAttribute(): ?array
    {
        if ($this->hero) {
            return HeroHelper::getUrl($this->hero->name);
        }
        return null;
    }
}
