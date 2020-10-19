<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {
        $data = $request->user()->notifications()->get();
        $response = [];
        foreach($data as $notif) {
            $arr = [
                'id' => $notif->id,
                'read_at' => $notif->read_at ? Carbon::parse($notif->read_at)->timestamp : null,
                'created_at' => Carbon::parse($notif->created_at)->timestamp,
                'data' => $notif->data,
            ];
            array_push($response, $arr);
        }
        return $response;
    }

    public function read(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        $response = [];
        switch($notification->type){
            case 'App\Notifications\ApproveCommentNotification' :
                if($notification->data['type'] === 'article') {
                    $post = Article::findOrFail($notification->data['post_id']);
                } else {
                    $post = Playlist::findOrFail($notification->data['post_id']);
                }
                $response = [
                    'slug' => $post->slug,
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
