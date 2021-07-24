<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'imageable_type',
        'imageable_id'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
