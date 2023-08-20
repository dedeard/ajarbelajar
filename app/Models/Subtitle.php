<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subtitle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }
}
