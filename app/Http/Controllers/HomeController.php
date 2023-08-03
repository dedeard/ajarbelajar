<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lesson;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $lessons = Lesson::listQuery()->orderBy('posted_at', 'desc')->take(8)->get();
        $categories = Category::whereHas('lessons', function ($q) {
            $q->where('public', true);
        })->withCount('lessons as lesson_count')->orderBy('lesson_count', 'asc')->paginate(8);
        $users = User::orderBy('created_at', 'desc')->take(8)->get();

        return view('home', compact('lessons', 'categories', 'users'));
    }
}
