<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestPlaylist extends Model
{
    protected $fillable = [
        'user_id',
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

    public function videos() : HasMany
    {
        return $this->hasMany(RequestVideo::class);
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
