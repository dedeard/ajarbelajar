<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user relation.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning activitiable model.
     */
    public function activitiable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Return Article reation.
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'activitiable_id');
    }

    /**
     * Return Playlist reation.
     */
    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'activitiable_id');
    }
}
