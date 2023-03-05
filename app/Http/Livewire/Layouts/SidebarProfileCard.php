<?php

namespace App\Http\Livewire\Layouts;

use App\Models\User;
use Livewire\Component;

class SidebarProfileCard extends Component
{
    public User $user;

    protected $listeners = ['profile-updated' => 'mount'];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.layouts.sidebar-profile-card');
    }
}
