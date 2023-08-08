<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EpisodeProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $episode)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Perform the video processing logic here
        // If there is nothing to do, consider removing this method or implementing the logic.
        // Otherwise, handle the video processing appropriately.
        throw new \Error('Cannot handle this job here');
    }
}
