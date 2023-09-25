<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Episode;
use App\Models\Subtitle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubtitleManagement extends Component
{
    use WithFileUploads;

    public Episode $episode;

    public $subtitles;

    public $language;

    public $languages;

    public $file;

    public function __construct()
    {
        $this->languages = config('languages');
    }

    public function mount()
    {
        $this->subtitles = $this->episode->subtitles()->get();
    }

    public function save()
    {
        $codes = implode(',', array_map(fn ($item) => $item['code'], $this->languages));
        $this->validate([
            'language' => ['required', 'in:' . $codes, Rule::unique('subtitles', 'code')->where(fn ($q) => $q->where('episode_id', $this->episode->id))],
            'file' => 'required|max:512|mimes:txt'
        ]);
        $ext = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $path = $this->file->storeAs('subtitles', Str::uuid() . ".$ext", 's3');
        $language = collect($this->languages)->first(fn ($item) => $item['code'] === $this->language);

        $subtitle = new Subtitle(
            [
                'name' =>  $language['name'],
                'code' => $language['code'],
                'url' => Storage::url($path)
            ]
        );

        $this->episode->subtitles()->save($subtitle);
        $this->file = null;
        $this->language = "";

        $this->mount();

        session()->flash('create_message', 'Subtitle berhasil dibuat.');
    }

    public function remove($id)
    {
        $subtitle = $this->episode->subtitles()->find($id);
        if ($subtitle) $subtitle->delete();
        $this->mount();
        session()->flash('delete_message', 'Subtitle berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.dashboard.subtitle-management');
    }
}
