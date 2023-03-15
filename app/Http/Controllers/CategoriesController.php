<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::whereHas('lessons', function ($q) {
            $q->where('public', true);
        })->orderBy('name', 'asc')->paginate(24);
        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, string $slug)
    {

        $category = Category::where('slug', $slug)->firstOrFail();

        $sort = $request->input('sort');
        abort_unless(in_array($sort ?? 'newest', ['newest', 'oldest', 'popularity']), 404);

        $query = Lesson::listQuery($category->lessons());

        if ($sort === 'oldest') {
            $query->orderBy('posted_at', 'asc');
        } else if ($sort === 'popularity') {
            $query->withCount('favorites as favorite_count')->orderBy('favorite_count', 'desc')->orderBy('title', 'asc');
        } else {
            $query->orderBy('posted_at', 'desc');
        }

        $lessons = $query->paginate(12)->appends(['sort' => $sort]);

        return view('categories.show', compact('lessons', 'sort', 'category'));
    }
}
