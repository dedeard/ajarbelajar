<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'title',
        'description'
    ];

    /**
     * Disbale timestamp.
     */
    public $timestamps = false;
}
