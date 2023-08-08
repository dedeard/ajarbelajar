<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Rules\Username;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.edit-profile');
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', new Username, 'max:15', 'min:6', 'unique:users,username,'.$user->id],
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
}
