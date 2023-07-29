<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Lesson;
use App\Notifications\CommentLikedNotification;
use App\Notifications\EpisodeCommentedNotification;
use App\Notifications\LessonFavoritedNotification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.notifications', compact('notifications'));
    }

    public function read(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        switch ($notification->type) {
            case CommentLikedNotification::class:
                $comment = Comment::with('episode.lesson')->findOrFail($notification->data['comment_id']);

                return redirect()->route('lessons.watch', ['lesson' => $comment->episode->lesson->slug, 'index' => $comment->episode->index]);
                break;

            case EpisodeCommentedNotification::class:
                $comment = Comment::with('episode.lesson')->findOrFail($notification->data['comment_id']);

                return redirect()->route('lessons.watch', ['lesson' => $comment->episode->lesson->slug, 'index' => $comment->episode->index]);
                break;

            case LessonFavoritedNotification::class:
                $lesson = Lesson::findOrFail($notification->data['lesson_id']);

                return redirect()->route('lessons.show', $lesson->slug);
                break;
        }
    }

    public function markall(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}
