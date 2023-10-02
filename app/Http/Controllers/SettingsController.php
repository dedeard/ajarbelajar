<?php

namespace App\Http\Controllers;

use App\Rules\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', new Username, 'max:15', 'min:6', 'unique:users,username,' . $user->id],
            'bio' => ['nullable', 'string', 'max:250'],
            'website' => ['nullable', 'url', 'max:250'],
            'avatar' => ['nullable', 'image', 'max:2048'], // Max file size 2MB
        ]);

        // Handle avatar upload and resize
        if ($request->hasFile('avatar')) {
            $user->generateAvatar($data['avatar']);
        }

        $user->update($request->except('avatar'));
        $user->lessons()->searchable();

        return redirect()->back()->withSuccess('Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', Password::defaults()],
        ]);
        $request->user()->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return redirect()->back()->withSuccess('Password berhasil diperbarui.');
    }
}
