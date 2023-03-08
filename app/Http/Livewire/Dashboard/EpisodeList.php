<?php

namespace App\Http\Livewire\Dashboard;

use App\Helpers\VideoHelper;
use App\Http\Livewire\LivewireAuthorizes;
use App\Models\Episode;
use Carbon\CarbonInterval;
use Livewire\Component;

class EpisodeList extends Component
{
    use LivewireAuthorizes;

    public Episode $episode;

    public $episode_title;
    public $duration;

    public function mount()
    {
        $this->duration = CarbonInterval::seconds($this->episode->seconds)->cascade()->format('%H:%I:%S');
        $this->episode_title = $this->episode->title;
    }

    public function updatedEpisodeTitle()
    {
        $user = $this->auth();
        abort_unless($user->id === $this->episode->lesson->user_id, 403);
        $data = $this->validate(['episode_title' => 'required|string|max:250']);
        $this->episode->update([
            'title' => $data['episode_title']
        ]);
    }

    public function destroy()
    {
        $user = $this->auth();
        abort_unless($user->id === $this->episode->lesson->user_id, 403);

        VideoHelper::destroy($this->episode->name);
        $this->episode->delete();
        $this->emit('episode-deleted');
    }

    public function render()
    {
        return view('livewire.dashboard.episode-list');
    }
}
