<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{

    public $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'imageable_type',
        'imageable_id'
    ];

    /**
     * Get the owning imageable model.
     */
    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }
}
