<?php

namespace App\Jobs;

use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EpisodeUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $episodeId, public array $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $episode = Episode::find($this->episodeId);
        if ($episode) {
            $episode->update($this->data);
        }
    }
}
