<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestVideo extends Model
{
    protected $fillable = [
        'name',
        'index'
    ];

    public function playlist() : BelongsTo
    {
        return $this->belongsTo(RequestPlaylist::class);
    }

    public function getUrl()
    {
        return VideoHelper::getUrl($this->name);
    }
}
