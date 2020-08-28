<?php

namespace App\Models;

use Overtrue\LaravelSubscribe\Subscription as Model;

class Subscription extends Model
{
    public function minitutor()
    {
        return $this->belongsTo(Minitutor::class, 'subscribable_id');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'subscribable_id');
    }
    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'subscribable_id');
    }
}
