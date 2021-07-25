<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification
{
    use Queueable;

    public $post;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
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
        $type = ($this->post->type) == 'article' ? 'Artikel' : 'Video';
        $minitutor = $this->post->minitutor->user;
        return (new MailMessage)
                    ->subject($type . ' baru dari MiniTutor ' . $minitutor->name . '.')
                    ->line("Halo $notifiable->name, MiniTutor $minitutor->name mempunyai satu $type baru nihh, dengan judul '{$this->post->title}'.")
                    ->action('Lihat ' . $type, config('frontend.url') . '/' . $this->post->type . 's/' . $this->post->slug);
    }

    public function toArray($notifiable)
    {
        $type = ($this->post->type) == 'article' ? 'Artikel' : 'Video';
        $minitutor = $this->post->minitutor->user;
        return [
            'post_id' => $this->post->id,
            'type' => $this->post->type,
            'message' => "Minitutor ". $minitutor->name . " telah menerbitkan satu " . $type . " baru."
        ];
    }
}
