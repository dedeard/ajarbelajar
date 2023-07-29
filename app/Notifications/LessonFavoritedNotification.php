<?php

namespace App\Notifications;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LessonFavoritedNotification extends Notification
{
    use Queueable;

    public $lesson = null;

    public $user = null;

    public function __construct(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'lesson_id' => $this->lesson->id,
            'message' => $this->user->name.' menambahkan pelajaran anda ke daftar favorit.',
            'user_id' => $this->user->id,
        ];
    }
}
