<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'name',
        'title',
        'index',
        'seconds',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Atributes
     */
    public function getVideoUrlAttribute(): string
    {
        return VideoHelper::getUrl($this->name);
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
