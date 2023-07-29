<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationCounter extends Component
{
    public $count = 0;

    public $user;

    protected function getListeners()
    {
        return ["echo-private:App.Models.User.{$this->user->id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'mount'];
    }

    public function mount()
    {
        $this->count = $this->user->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.notification-counter');
    }
}
