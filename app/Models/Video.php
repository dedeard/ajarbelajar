<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $fillable = [
        'playlist_id',
        'name',
        'index'
    ];

    public function playlist() : BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    public function getUrl()
    {
        return VideoHelper::getUrl($this->name);
    }
}
