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
}
