<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\LivewireAuthorizes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class EditPassword extends Component
{
    use LivewireAuthorizes;

    public User $user;

    public $current_password = "";
    public $new_password = "";

    public function mount()
    {
        $this->user = $this->auth();
    }

    protected function rules()
    {
        return [
            'current_password' => ['required'],
            'new_password' => ['required', Password::defaults()]
        ];
    }

    public function submit()
    {
        $data = $this->validate();
        if (!Hash::check($data['current_password'], $this->user->password)) {
            return session()->flash('error', 'Password saat ini tidak valid.');
        }
        $this->user->update([
            "password" => Hash::make($data['new_password'])
        ]);
        $this->current_password = "";
        $this->new_password = "";
        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.dashboard.edit-password');
    }
}
