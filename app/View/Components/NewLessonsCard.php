<?php

namespace App\View\Components;

use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewLessonsCard extends Component
{

    public $lessons;

    /**
     * Create a new component instance.
     */
    public function __construct(public int $ignoreId)
    {
        $this->lessons = Lesson::listQuery()
            ->where('id', '!=', $this->ignoreId)
            ->orderBy('posted_at', 'desc')
            ->take(6)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.new-lessons-card');
    }
}
