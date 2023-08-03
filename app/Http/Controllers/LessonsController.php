<?php

namespace App\Http\Controllers;

use App\Events\EpisodeWatchedEvent;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        abort_unless(in_array($sort ?? 'newest', ['newest', 'oldest', 'popularity']), 404);

        $query = Lesson::listQuery();

        if ($sort === 'oldest') {
            $query->orderBy('posted_at', 'asc');
        } elseif ($sort === 'popularity') {
            $query->withCount('favorites as favorite_count')->orderBy('favorite_count', 'desc')->orderBy('title', 'asc');
        } else {
            $query->orderBy('posted_at', 'desc');
        }

        $lessons = $query->paginate(12)->appends(['sort' => $sort]);

        return view('lessons.index', compact('lessons', 'sort'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $lesson = Lesson::listQuery()->where('slug', $slug)->firstOrFail();

        return view('lessons.show', compact('lesson'));
    }

    /**
     * Display the specified resource.
     */
    public function watch(Request $request, string $slug)
    {
        $index = $request->input('index') ?? 0;
        $lesson = Lesson::listQuery()->where('slug', $slug)->firstOrFail();
        $episode = $lesson->episodes()->where('index', $index)->firstOrFail();

        EpisodeWatchedEvent::dispatch($episode, $request->user());

        return view('lessons.watch', compact('lesson', 'episode', 'index'));
    }
}
