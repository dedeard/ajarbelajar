<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'path',
        'title',
        'description',
        'type',
        'robots'
    ];

    public $timestamps = false;
}
