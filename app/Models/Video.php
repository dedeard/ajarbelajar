<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'original_name',
        'index'
    ];

    /**
     * Get the owning videoable model.
     */
    public function videoable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get video url.
     */
    public function getUrl() : String
    {
        return VideoHelper::getUrl($this->name);
    }
}
