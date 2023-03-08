<?php

namespace App\Models;

use App\Helpers\CoverHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'user_id',
        'category_id',
        'cover',
        'title',
        'slug',
        'content',
        'public',
        'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Atributes
     */
    public function getCoverUrlAttribute()
    {
        return CoverHelper::getUrl($this->cover);
    }
}
