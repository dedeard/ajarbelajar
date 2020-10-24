<?php

namespace App\Jobs;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AfterViewPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post, $user = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $user = null)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->user) {
            $q = $this->post->activities()->where('user_id', $this->user->id);
            if ($q->exists()){
                $activity = $q->first();
                $activity->updated_at = now();
                $activity->save();
            } else {
                $activity = new Activity([ 'user_id' => $this->user->id ]);
                $this->post->activities()->save($activity);
                if($this->user->activities()->count() > 8) {
                    $this->user->activities()->orderBy('updated_at', 'asc')->first()->delete();
                }
            }
        }
    }
}
