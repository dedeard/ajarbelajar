<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MinitutorPostPublishedNotification extends Notification
{
    use Queueable;

    public $post = null, $type = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post, $type)
    {
        $this->post = $post;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $type = ($this->type) == 'article' ? 'Artikel' : 'Playlist';
        return [
            'post_id' => $this->post->id,
            'type' => $this->type,
            'message' => $type . " anda yang berjudul '" . $this->post->title . "' telah dipublikasikan."
        ];
    }
}
