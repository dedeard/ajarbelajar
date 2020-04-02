<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name'];
    public function videoable()
    {
        return $this->morphTo();
    }
}
