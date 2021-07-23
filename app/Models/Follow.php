<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'minitutor_id'
    ];

    /**
     * Get the user relation.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the minitutor relation.
     */
    public function minitutor(): BelongsTo
    {
        return $this->belongsTo(Minitutor::class);
    }
}
