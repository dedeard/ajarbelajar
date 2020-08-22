<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RequestPlaylist extends Model
{
    protected $fillable = [
        'category_id',
        'requested_at',
        'title',
        'hero',
        'description'
    ];

    public function minitutor() : BelongsTo
    {
        return $this->belongsTo(Minitutor::class);
    }

    public function videos() : MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
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
