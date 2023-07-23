<?php

namespace App\Jobs;

use App\Models\Activity;
use App\Models\Episode;
use App\Models\User;
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
    public function __construct(public Episode $episode, public ?User $user = null)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->user) {
            $q = $this->user->activities()->where('episode_id', $this->episode->id);
            if ($q->exists()) {
                $activity = $q->first();
                $activity->touch();
            } else {
                $activity = new Activity(['episode_id' => $this->episode->id]);
                $this->user->activities()->save($activity);
                if ($this->user->activities()->count() > 20) {
                    $activity = $this->user->activities()->orderBy('updated_at', 'asc')->first();
                    $activity->delete();
                }
            }
        }
    }
}
