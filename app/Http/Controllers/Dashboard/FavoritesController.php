<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\LessonFavoritedEvent;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Lesson;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $favorites = $user->favorites()->with('lesson', fn ($q) => $q->listQuery())->orderBy('created_at', 'desc')->paginate(12);

        return view('dashboard.favorites', compact('favorites'));
    }

    public function toggle(Request $request, $lessonId)
    {
        $user = $request->user();
        $favorite = $user->favorites()->firstWhere('lesson_id', $lessonId);
        $favorited = false;
        if (!$favorite) {
            $lesson = Lesson::where('public', true)->findOrFail($lessonId);
            $data = new Favorite(['lesson_id' => $lessonId]);
            $user->favorites()->save($data);
            LessonFavoritedEvent::dispatch($lesson, $user);
            $favorited = true;
        } else if ($favorite) {
            $favorite->delete();
        }
        return response()->json(['favorited' => $favorited], 200);
    }
}
