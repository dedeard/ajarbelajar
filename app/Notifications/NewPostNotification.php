<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $post, $type;
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
        if((bool) $notifiable->email_notification) {
            return ['database', 'broadcast', 'mail'];
        }
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $type = ($this->type) == 'article' ? 'Artikel' : 'Playlist';
        $minitutor = $this->post->minitutor->user;
        return (new MailMessage)
                    ->subject($type . ' baru dari MiniTutor ' . $minitutor->name . '.')
                    ->line("Halo $notifiable->name, MiniTutor $minitutor->name mempunyai satu $type baru nihh, dengan judul '{$this->post->title}'.")
                    ->action('Lihat ' . $type, config('frontend.url') . '/' . $this->type . 's/' . $this->post->slug);
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
        $minitutor = $this->post->minitutor->user;
        return [
            'post_id' => $this->post->id,
            'type' => $this->type,
            'message' => "Minitutor ". $minitutor->name . " telah menerbitkan satu " . $type . " baru."
        ];
    }
}
