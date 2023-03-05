<?php

namespace App\Http\Livewire\Dashboard\Lessons;

use App\Helpers\VideoHelper;
use App\Http\Livewire\LivewireAuthorizes;
use App\Models\Episode;
use App\Models\Lesson;
use Livewire\Component;
use Livewire\WithFileUploads;
use getID3;
use Illuminate\Validation\ValidationException;

class UploadEpisode extends Component
{
    use WithFileUploads, LivewireAuthorizes;

    public Lesson $lesson;

    public $video;

    protected function rules()
    {
        return [
            'video' => 'required|mimes:mp4,mov,avi,fly|max:' . env('MAX_VIDEO_SIZES', '25000'),
        ];
    }

    public function updatedVideo()
    {
        $user = $this->auth();
        abort_unless($this->lesson->user_id === $user->id, 403);
        ini_set('memory_limit', '-1');

        $data = null;
        try {
            $data = $this->validate();
        } catch (ValidationException $e) {
            $this->dispatchBrowserEvent('episode-error');
            $this->validate();
        }

        $getID3 = new getID3;
        $title = pathinfo($data['video']->getClientOriginalName(), PATHINFO_FILENAME);
        $tmp_name = $data['video']->getRealPath();
        $seconds = $getID3->analyze($tmp_name)['playtime_seconds'];
        $index = $this->lesson->episodes()->count();
        $name = VideoHelper::upload($data['video']);

        if (file_exists($tmp_name)) {
            unlink($tmp_name);
        }

        $episode = new Episode([
            'name' => $name,
            'title' => $title,
            'index' => $index,
            'seconds' => $seconds,
        ]);

        $this->lesson->episodes()->save($episode);
        $this->video = null;
        $this->emit('episode-created');
        $this->dispatchBrowserEvent('episode-created');
        session()->flash('message', 'Episode berhasil dibuat');
    }

    public function render()
    {
        return view('livewire.dashboard.lessons.upload-episode');
    }
}
