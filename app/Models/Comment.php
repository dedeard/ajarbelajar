<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'episode_id',
        'body',
        'like_count'
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

    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    public function liked(int $userId): bool
    {
        return  $this->likes()->where('user_id', $userId)->exists();
    }

    public function like(int $userId): void
    {
        if (!$this->liked($userId)) {
            CommentLike::create(['user_id' => $userId, 'comment_id' => $this->id]);
            $this->increment('like_count');
        }
    }

    public function unlike(int $userId): void
    {
        if ($this->liked($userId)) {
            $this->likes()->where('user_id', $userId)->delete();
            if ($this->like_count > 0) {
                $this->decrement('like_count');
            }
        }
    }

    public function getHtmlBodyAttribute(): string
    {
        return $this->body ? Str::marked($this->body, 'minimal') : '';
    }
}
