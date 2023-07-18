<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use App\Models\User;
use App\Notifications\LessonFavoritedNotification;
use Livewire\Component;

class FavoriteToggle extends Component
{
    public Lesson $lesson;
    public User $user;
    public $favorited;
    public bool $small = false;

    public function mount()
    {
        if (isset($this->user)) {
            $this->favorited = $this->user->hasFavorited($this->lesson->id);
        } else {
            $this->favorited = false;
        }
    }

    public function onclick()
    {
        $this->favorited = $this->user->favoriteToggle($this->lesson->id);
        if ($this->favorited) {
            $notifications = $this->lesson->user->notifications()->where('type', LessonFavoritedNotification::class)->get();
            $exists = false;
            foreach ($notifications as $notification) {
                if ($notification->data['lesson_id'] == $this->lesson->id && $notification->data['user_id'] == $this->user->id) {
                    $exists = true;
                }
                break;
            }
            if (!$exists) {
                $this->lesson->user->notify(new LessonFavoritedNotification($this->lesson, $this->user));
            }
        }
    }

    public function render()
    {
        return view('livewire.favorite-toggle');
    }
}
