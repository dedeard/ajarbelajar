<?php

namespace App\Notifications;

use App\Model\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewPost extends Notification
{
    use Queueable;

    private $post, $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Postingan baru dari MiniTutor ' . $this->post->user->name())
                    ->line('Hi ' . $this->user->name() . ', Minitutor ' . $this->post->user->name() . ' mempunyai satu postingan baru `' . $this->post->title . '`')
                    ->action('Lihat Post', route('post.show', $this->post->slug));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->post->id,
            'type' => $this->post->type,
        ];
    }
}
