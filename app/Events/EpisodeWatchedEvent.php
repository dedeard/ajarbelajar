<?php

namespace App\Events;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EpisodeWatchedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Episode $episode;
    public ?User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Episode $episode, ?User $user = null)
    {
        $this->episode = $episode;
        $this->user = $user;
    }
}
