<?php

namespace App\Jobs;

use App\Events\EpisodeWatchedEvent;
use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AftarWatchEpisodeJob implements ShouldQueue
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
            $q = $event->user->activities()->where('episode_id', $event->episode->id);
            if ($q->exists()) {
                $activity = $q->first();
                $activity->touch();
            } else {
                $activity = new Activity(['episode_id' => $event->episode->id]);
                $event->user->activities()->save($activity);
                if ($event->user->activities()->count() > 20) {
                    $activity = $event->user->activities()->orderBy('updated_at', 'asc')->first();
                    $activity->delete();
                }
            }
        }
    }
}
