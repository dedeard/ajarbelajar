<?php

namespace App\Http\Livewire;

use App\Notifications\CommentLikedNotification;
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
                $notifications = $this->comment->user->notifications()->where('type', CommentLikedNotification::class)->get();
                $exists = false;
                foreach ($notifications as $notification) {
                    if ($notification->data['comment_id'] == $this->comment->id) {
                        $exists = true;
                    }
                    break;
                }
                if (!$exists) {
                    $this->comment->user->notify(new CommentLikedNotification($this->comment, $this->user));
                }
            }
            $this->comment->refresh();
        }
    }

    public function render()
    {
        return view('livewire.comment-list');
    }
}
