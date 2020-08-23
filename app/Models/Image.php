<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'original_name',
        'type',
    ];

    /**
     * Get the owning imageable model.
     */
    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }
}
