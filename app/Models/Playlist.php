<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Playlist extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id',
        'category_id',
        'draf',
        'title',
        'slug',
        'hero',
        'description'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function minitutor() : BelongsTo
    {
        return $this->belongsTo(Minitutor::class);
    }

    public function videos() : HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function heroUrl() : Array
    {
        return HeroHelper::getUrl($this->hero);
    }
}
