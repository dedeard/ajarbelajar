<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentList extends Component
{
    public $user;
    public $comment;

    public function render()
    {
        return view('livewire.comment-list');
    }
}
