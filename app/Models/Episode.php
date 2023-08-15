<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'name',
        'title',
        'description',
        'index',
        'seconds',
        'm3u8_processing_status',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function comments(): HasMany
    {
        return $this->HasMany(Comment::class);
    }

    /**
     * Atributes
     */
    public function getVideoUrlAttribute(): string
    {
        if ($this->m3u8_processing_status === 'success') {
            return VideoHelper::getM3u8PlaylistUrl($this->name);
        }

        return VideoHelper::getVideoUrl($this->name);
    }

    public function getReadableSecondAttribute()
    {
        return CarbonInterval::seconds($this->seconds)->cascade()->format('%H:%I:%S');
    }

    public function getHtmlDescriptionAttribute()
    {
        return $this->description ? Str::marked($this->description, 'minimal') : '';
    }
}
