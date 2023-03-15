<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $favorites = $user->favorites()->with('lesson', function ($q) {
            Lesson::listQuery($q);
        })->orderBy('created_at', 'desc')->paginate(12);

        return view('dashboard.favorites', compact('favorites'));
    }
}
