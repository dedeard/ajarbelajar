<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Playlist;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function read(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        $response = [];
        switch($notification->data['type']){
            case 'article' :
                $post = Article::findOrFail($notification->data['post_id']);
                $response = [
                    'slug' => $post->slug,
                    'type' => $notification->data['type']
                ];
            break;
            case 'playlist':
                $post = Playlist::findOrFail($notification->data['post_id']);
                $response = [
                    'slug' => $post->slug,
                    'type' => $notification->data['type']
                ];
            break;
            default :
                $response = [
                    'type' => $notification->data['type']
                ];
            break;
        }
        return $response;
    }

    public function markAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return true;
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->notifications()->delete();
        return true;
    }
}
