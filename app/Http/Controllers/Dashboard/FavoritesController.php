<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $favorites = $user->favorites()->with('lesson', fn ($q) => $q->listQuery())->orderBy('created_at', 'desc')->paginate(12);

        return view('dashboard.favorites', compact('favorites'));
    }
}
