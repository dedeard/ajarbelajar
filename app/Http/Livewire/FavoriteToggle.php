<?php

namespace App\Http\Livewire;

use App\Events\LessonFavoritedEvent;
use App\Models\Lesson;
use App\Models\User;
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
            LessonFavoritedEvent::dispatch($this->lesson, $this->user);
        }
    }

    public function render()
    {
        return view('livewire.favorite-toggle');
    }
}
