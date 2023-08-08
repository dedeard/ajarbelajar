<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'name',
        'title',
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
        if ($this->seconds) {
            $hours = floor($this->seconds / 3600);
            $minutes = floor(($this->seconds / 60) % 60);
            $seconds = $this->seconds % 60;

            return gmdate('H:i:s', mktime($hours, $minutes, $seconds));
        }

        return '';
    }
}
