<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
        'article_id',
        'name',
        'index'
    ];

    public function article() : BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function getUrl()
    {
        // return VideoHelper::getUrl($this->name);
    }
}
