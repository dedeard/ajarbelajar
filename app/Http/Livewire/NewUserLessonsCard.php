<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Livewire\Component;

class NewUserLessonsCard extends Component
{
    public $lessons;

    public $user;

    public $ignoreId;

    public function mount()
    {
        $this->lessons = Lesson::listQuery()
            ->where('user_id', $this->user->id)
            ->where('id', '!=', $this->ignoreId)
            ->orderBy('posted_at', 'desc')
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.new-user-lessons-card');
    }
}
