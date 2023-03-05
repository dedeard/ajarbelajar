<?php

namespace App\Http\Livewire\Dashboard\Lessons;

use App\Http\Livewire\LivewireAuthorizes;
use App\Models\Lesson;
use Illuminate\Support\Arr;
use Livewire\Component;

class ShowEpisodes extends Component
{
    use LivewireAuthorizes;

    public Lesson $lesson;
    public $episodes;
    public $index;

    protected $listeners = ['episode-created' => 'mount', 'episode-deleted' => 'mount'];

    public function mount()
    {
        $this->episodes = $this->lesson->episodes()->orderBy('index')->get();
        $ids = [];
        foreach ($this->episodes as $episode) {
            array_push($ids, $episode->id);
        }
        $this->index = implode(',', $ids);
    }

    public function updatedIndex()
    {
        $user = $this->auth();
        abort_unless($user->id === $this->lesson->user_id, 403);

        $index = explode(',', $this->index);

        $filtered_episodes = [];
        foreach ($index as $id) {
            $filtered = Arr::where($this->episodes->toArray(), function ($episode) use ($id) {
                return $episode['id'] == $id;
            });
            $filtered = Arr::first($filtered);
            if ($filtered) array_push($filtered_episodes, $filtered);
        }

        if (count($filtered_episodes) === count($this->episodes)) {
            foreach ($filtered_episodes as $key => $filtered) {
                $episode = $this->episodes->firstWhere('id', $filtered['id']);
                $episode?->update(['index' => $key]);
            }
        }

        $this->mount();
    }

    public function render()
    {
        return view('livewire.dashboard.lessons.show-episodes');
    }
}
