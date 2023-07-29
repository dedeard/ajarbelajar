<?php

namespace App\Models;

use App\Helpers\CoverHelper;
use App\Helpers\EditorjsHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Lesson extends Model
{
    use HasFactory, HasSlug, Searchable;

    protected $fillable = [
        'user_id',
        'category_id',
        'cover',
        'title',
        'slug',
        'description',
        'public',
        'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'cover_url' => $this->cover_url['small'],
            'category' => $this->category->name,
            'author' => $this->user->name,
            'episodes' => $this->episodes->pluck('title')->implode(' '),
            'description' => strip_tags($this->htmlDescription),
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->isPublished();
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('user')->with('category')->with('episodes');
    }

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

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function isPublished(): bool
    {
        return $this->public ? true : false;
    }

    /**
     * Atributes
     */
    public function getCoverUrlAttribute()
    {
        return CoverHelper::getUrl($this->cover);
    }

    public function getReadableSecondAttribute()
    {
        if ($this->seconds) {
            $hours = floor($this->seconds / 3600);
            $minutes = floor(($this->seconds / 60) % 60);
            $seconds = $this->seconds % 60;
            $msg = '';
            if ($hours) {
                $msg .= "$hours Jam ";
            }
            if ($minutes) {
                $msg .= "$minutes Menit ";
            }
            if ($seconds) {
                $msg .= "$seconds Detik";
            }

            return trim($msg);
        }

        return '';
    }

    public function getHtmlDescriptionAttribute()
    {
        if ($this->description) {
            return EditorjsHelper::compile($this->description);
        }

        return '';
    }

    public function getSeoDescriptionAttribute()
    {
        if ($this->description) {
            $str = EditorjsHelper::firstParagraph($this->description);
            $max = 150;
            if (strlen($str) > $max) {
                $offset = ($max - 3) - strlen($str);
                $str = substr($str, 0, strrpos($str, ' ', $offset)).'...';
            }

            return $str;
        }

        return '';
    }

    // Query
    public static function listQuery($model, $publicOnly = true)
    {
        $model->with(['user', 'category'])
            ->withCount(['episodes as seconds' => function ($q) {
                $q->select(DB::raw('sum(seconds)'));
            }, 'episodes']);
        if ($publicOnly) {
            $model->where('public', true);
        }

        return $model;
    }
}
