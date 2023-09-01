<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Episode;
use App\Models\Subtitle;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubtitleManagement extends Component
{
    use WithFileUploads;

    public Episode $episode;

    public $subtitles;

    public $language;

    public $file;

    public function mount()
    {
        $this->subtitles = $this->episode->subtitles()->get();
    }

    public function save()
    {
        $this->validate([
            'language' => 'required|string',
            'file' => 'required|max:512|mimetypes:text/plain,application/octet-stream'
        ]);
        $name = Str::uuid() . '.srt';
        $this->file->store('subtitles/' . $name, 'public');
        $subtitle = new Subtitle(['name' => 'subtitles/' . $name, 'language' => $this->language]);
        $this->episode->subtitles()->save($subtitle);

        $this->mount();
    }

    public function render()
    {
        return view('livewire.dashboard.subtitle-management');
    }
}
