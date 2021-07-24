<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestMinitutorRejectedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'join.minitutor',
            'message' => 'Mohon maaf, permintaan anda untuk menjadi MiniTutor Ajarbelajar tidak diterima karena belum memenuhi persyaratan.'
        ];
    }
}
