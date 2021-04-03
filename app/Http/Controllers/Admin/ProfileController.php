<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return redirect()->route('users.show', Auth::user()->id);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
