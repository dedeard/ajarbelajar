<?php

namespace App\Jobs;

use App\Model\Notified;
use App\Model\Post;
use App\Notifications\NewPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNewPostNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post_id;
    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $post = Post::find($this->post_id);
        if(!$post) return 0;
        $notified = Notified::where('type', 'App\Notifications\NewPost')->where('target_id', $post->id)->exists();
        if($notified) return 0;

        foreach($post->user->minitutor->subscribers()->get() as $user) {
            $user->notify(new NewPost($post, $user));
        }

        Notified::create([
            'type' => 'App\Notifications\NewPost',
            'target_id' => $post->id
        ]);
        return true;
    }
}
