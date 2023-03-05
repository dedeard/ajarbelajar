<?php

namespace App\Http\Livewire\Dashboard\Lessons;

use App\Http\Livewire\LivewireAuthorizes;
use App\Models\Category;
use App\Models\Lesson;
use Livewire\Component;

class EditInformation extends Component
{
    use LivewireAuthorizes;

    public Lesson $lesson;

    public $title;
    public $category;
    public $description;
    public $public;

    protected $rules = [
        'title' => 'required|string|max:250',
        'category' => 'required|exists:categories,id',
        'description' => 'required|string|max:2500',
        'public' => 'required|boolean',
    ];

    public function mount()
    {
        $this->title = $this->lesson->title;
        $this->category = $this->lesson->category_id ?? '';
        $this->description = $this->lesson->description;
        $this->public = $this->lesson->public;
    }

    public function submit()
    {
        $user = $this->auth();
        abort_unless($this->lesson->user_id === $user->id, 403);

        $data = $this->validate();
        $data['category_id'] = $data['category'];

        if ($data['public'] && !$this->lesson->posted_at) {
            $data['posted_at'] = now();
            $this->lesson->update($data);
            // event(new LessonPublished($this->lesson));
        } else {
            $this->lesson->update($data);
        }
        session()->flash('message', 'Pelajaran berhasil diperbarui');
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        return view('livewire.dashboard.lessons.edit-information', ['categories' => $categories]);
    }
}
