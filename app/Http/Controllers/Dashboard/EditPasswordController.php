<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditPasswordController extends Controller
{
    public function index()
    {
        return view('dashboard.edit-password');
    }

    public function update(Request $request)
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
