<?php

namespace App\Http\Livewire\Dashboard\Lessons;

use App\Helpers\CoverHelper;
use App\Http\Livewire\LivewireAuthorizes;
use App\Models\Lesson;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCover extends Component
{
    use WithFileUploads, LivewireAuthorizes;

    public Lesson $lesson;

    public $image;

    protected $rules = ['image' => 'required|image|max:4000'];

    public function updatedImage()
    {
        $user = $this->auth();
        abort_unless($this->lesson->user_id === $user->id, 403);

        $data = null;
        try {
            $data = $this->validate();
        } catch (ValidationException $e) {
            $this->dispatchBrowserEvent('cover-error');
            $this->validate();
        }

        $name = CoverHelper::generate($data['image'], $this->lesson->cover);

        $tmp_name = $data['image']->getRealPath();
        if (file_exists($tmp_name)) {
            unlink($tmp_name);
        }

        $this->lesson->cover = $name;
        $this->lesson->save();

        session()->flash('message', 'Gambar pelajaran berhasil diperbarui');
        $this->dispatchBrowserEvent('cover-created');
    }

    public function render()
    {
        return view('livewire.dashboard.lessons.edit-cover');
    }
}
