<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory, Likeable;

    protected $fillable = [
        'user_id',
        'episode_id',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

    public function isMine(): bool
    {
        $user = Auth::user();
        if ($user && $user->id === $this->user_id) {
            return true;
        }

        return false;
    }

    public function getHtmlBodyAttribute()
    {
        return $this->body ? Str::marked($this->body, 'minimal') : '';
    }
}
