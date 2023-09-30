<?php

namespace App\Models;

use App\Events\CommentLikedEvent;
use App\Events\CommentUnlikedEvent;
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

    public function liked(User $user): bool
    {
        return  $this->likes()->where('user_id', $user->id)->exists();
    }

    public function like(User $user): void
    {
        if (!$this->liked($user)) {
            CommentLike::create(['user_id' => $user->id, 'comment_id' => $this->id]);
            $this->increment('like_count');
            CommentLikedEvent::dispatch($this, $user);
        }
    }

    public function unlike(User $user): void
    {
        if ($this->liked($user)) {
            $this->likes()->where('user_id', $user->id)->delete();
            if ($this->like_count > 0) {
                $this->decrement('like_count');
            }
            CommentUnlikedEvent::dispatch($this, $user);
        }
    }

    public function getHtmlBodyAttribute(): string
    {
        return $this->body ? Str::marked($this->body, 'minimal') : '';
    }


    public function scopeListQuery($model, $auth = null)
    {
        if ($auth) {
            $model->with(['likes' => fn ($q) => $q->where('user_id', $auth->id)]);
        }
        $model->with('user');

        return $model;
    }
}
