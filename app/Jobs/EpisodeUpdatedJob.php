<?php

namespace App\Jobs;

use App\Events\EpisodeUpdated;
use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EpisodeUpdatedJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(EpisodeUpdated $event): void
    {
        $episode = Episode::find($event->episodeId);
        if ($episode) {
            $episode->update($event->data);
        }
    }
}
