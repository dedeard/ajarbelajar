<?php

namespace App\models;

use App\Helpers\HeroHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RequestArticle extends Model
{
    protected $fillable = [
        'category_id',
        'requested_at',
        'title',
        'hero',
        'description',
        'body',
    ];

    public function minitutor() : BelongsTo
    {
        return $this->belongsTo(Minitutor::class);
    }

    public function images() : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
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
