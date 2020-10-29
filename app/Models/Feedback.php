<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Feedback extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sync_with_me',
        'understand',
        'inspiring',
        'language_style',
        'content_flow',
        'message',
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
     * Get the owning feedbackable model.
     */
    public function feedbackable() : MorphTo
    {
        return $this->morphTo();
    }

    public function getRatingAttribute()
    {
        return ceil(($this->understand + $this->inspiring + $this->language_style + $this->content_flow)/4);
    }


}
