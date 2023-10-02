<?php

namespace App\Jobs;

use App\Events\EpisodeWatchedEvent;
use App\Models\History;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EpisodeWatchedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(EpisodeWatchedEvent $event): void
    {
        if ($event->user) {
            $q = $event->user->histories()->where('episode_id', $event->episode->id);
            if ($q->exists()) {
                $history = $q->first();
                $history->touch();
            } else {
                $history = new History(['episode_id' => $event->episode->id]);
                $event->user->histories()->save($history);
                if ($event->user->histories()->count() > 20) {
                    $history = $event->user->histories()->orderBy('updated_at', 'asc')->first();
                    $history->delete();
                }
            }
        }
    }
}
