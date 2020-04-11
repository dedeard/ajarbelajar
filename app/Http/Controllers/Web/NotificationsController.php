<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('web.notifications', ['notifications' => $user->notifications()->paginate(20)]);
    }

    public function read(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        switch($notification->type){
            case "App\Notifications\ApproveComment":
                $post = Post::findOrFail($notification->data['post_id']);
                return redirect()->route('post.show', $post->slug);
            break;
            case "App\Notifications\CommentToMinitutorPost":
                $post = Post::findOrFail($notification->data['post_id']);
                return redirect()->route('post.show', $post->slug);
            break;
            case "App\Notifications\NewPost":
                $post = Post::findOrFail($notification->data['id']);
                return redirect()->route('post.show', $post->slug);
            break;
            case "App\Notifications\PostUpdated":
                $post = Post::findOrFail($notification->data['id']);
                return redirect()->route('post.show', $post->slug);
            break;
            case "App\Notifications\ApprovePost":
                $post = Post::findOrFail($notification->data['id']);
                return redirect()->route('dashboard.minitutor.accepted.index');
            break;
            case "App\Notifications\ReviewToMinitutorPost":
                return redirect()->route('dashboard.minitutor.reviews.index');
            break;
            case "App\Notifications\RequestMinitutorAccepted":
                return redirect()->route('dashboard.minitutor.index');
            break;
            case "App\Notifications\RequestMinitutorRejected":
                return redirect()->route('join.minitutor.create');
            break;
        }
    }

    public function markAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }
    
    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->notifications()->delete();
        return redirect()->back();
    }
}
