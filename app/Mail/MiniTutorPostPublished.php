<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MiniTutorPostPublished extends Mailable
{
    use Queueable, SerializesModels;

    public $title = '';
    public $slug = '';
    public $name = '';
    public $username = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->name = $post->user ? $post->user->name() : '';
        $this->username = $post->user ? $post->user->username : '';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.minitutor_post_published');
    }
}
