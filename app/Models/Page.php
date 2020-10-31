<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'draf',
        'title',
        'slug',
        'description',
        'body',
        'view_count'
    ];

    /**
     * Get the hero relation.
     */
    public function hero() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'hero');
    }

    /**
     * Get the images relation.
     */
    public function images() : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'image');
    }

    /**
     * Return the hero url or placeholder url lists.
     */
    public function heroUrl() : Array
    {
        return HeroHelper::getUrl($this->hero ? $this->hero->name : null);
    }
}
