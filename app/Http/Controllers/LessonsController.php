<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::listQuery(Lesson::query())->get();
        return view('lessons.index', compact('lessons'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $lesson = Lesson::listQuery(Lesson::where('slug', $slug))->firstOrFail();
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Display the specified resource.
     */
    public function watch(Request $request, string $slug)
    {
        $index = $request->input('index') ?? 0;
        $lesson = Lesson::listQuery(Lesson::where('slug', $slug))->firstOrFail();
        $episode = $lesson->episodes()->where('index', $index)->firstOrFail();

        return view('lessons.watch', compact('lesson', 'episode', 'index'));
    }
}
