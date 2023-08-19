<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Comments extends Component
{
    public $episode;

    public $comments;

    public $user;

    protected $listeners = ['comment-created' => 'mount', 'comment-deleted' => 'mount', 'comment-updated' => 'mount'];

    public function mount()
    {
        $this->comments = $this->episode->comments()->with('user', 'likeCounter')->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
