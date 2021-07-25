<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function read(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        $response = [];
        switch($notification->data['type']){
            case 'article' :
                $post = Post::where('type', 'article')->findOrFail($notification->data['post_id']);
                $response = [
                    'slug' => $post->slug,
                    'type' => $notification->data['type']
                ];
            break;
            case 'video':
                $post = Post::where('type', 'video')->findOrFail($notification->data['post_id']);
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
