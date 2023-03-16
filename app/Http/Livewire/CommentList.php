<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentList extends Component
{
    public $user;
    public $comment;

    public function likeToggle()
    {
        if ($this->user) {
            if ($this->comment->liked()) {
                $this->comment->unlike();
            } else {
                $this->comment->like();
            }
            $this->comment->refresh();
        }
    }

    public function render()
    {
        return view('livewire.comment-list');
    }
}
