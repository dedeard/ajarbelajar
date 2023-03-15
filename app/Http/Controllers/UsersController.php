<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(24);
        return view('users.index', compact('users'));
    }

    public function show(Request $request, string $username)
    {

        $user = User::where('username', $username)->firstOrFail();

        $sort = $request->input('sort');
        abort_unless(in_array($sort ?? 'newest', ['newest', 'oldest', 'popularity']), 404);

        $query = Lesson::listQuery($user->lessons());

        if ($sort === 'oldest') {
            $query->orderBy('posted_at', 'asc');
        } else if ($sort === 'popularity') {
            $query->withCount('favorites as favorite_count')->orderBy('favorite_count', 'desc')->orderBy('title', 'asc');
        } else {
            $query->orderBy('posted_at', 'desc');
        }

        $lessons = $query->paginate(12)->appends(['sort' => $sort]);

        return view('users.show', compact('lessons', 'sort', 'user'));
    }
}
