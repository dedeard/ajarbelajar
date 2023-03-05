<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\LivewireAuthorizes;
use App\Models\User;
use App\Rules\Username;
use Livewire\Component;

class EditProfile extends Component
{
    use LivewireAuthorizes;

    public User $user;

    public $name;
    public $username;
    public $bio;
    public $website;

    public function mount()
    {
        $this->user = $this->auth();
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->bio = $this->user->bio;
        $this->website = $this->user->website;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', new Username, 'max:15', 'min:6', 'unique:users,username,' . $this->user->id],
            'bio' => ['nullable', 'string', 'max:250'],
            'website' => ['nullable', 'url', 'max:250'],
        ];
    }

    public function submit()
    {
        $data = $this->validate();
        $this->user->update($data);
        session()->flash('success', 'Profil berhasil diperbarui.');
        $this->emit('profile-updated');
    }

    public function render()
    {
        return view('livewire.dashboard.edit-profile');
    }
}
