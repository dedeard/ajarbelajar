<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Livewire\Component;

class NewLessonsCard extends Component
{
    public $lessons;

    public $ignoreId;

    public function mount()
    {
        $this->lessons = Lesson::listQuery()
            ->where('id', '!=', $this->ignoreId)
            ->orderBy('posted_at', 'desc')
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.new-lessons-card');
    }
}
