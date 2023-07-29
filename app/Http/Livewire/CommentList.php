<?php

namespace App\Http\Livewire;

use App\Events\CommentLikedEvent;
use App\Events\CommentUnlikedEvent;
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
                broadcast(new CommentUnlikedEvent($this->comment, $this->user))->toOthers();
            } else {
                $this->comment->like();
                broadcast(new CommentLikedEvent($this->comment, $this->user))->toOthers();
            }
            $this->refresh();
        }
    }

    public function refresh()
    {
        $this->comment->refresh();
    }

    public function getListeners()
    {
        return [
            "echo:Comment.Updated,.{$this->comment->id}" => 'refresh',
        ];
    }

    public function render()
    {
        return view('livewire.comment-list');
    }
}
