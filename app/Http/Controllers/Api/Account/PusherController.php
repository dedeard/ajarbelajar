<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherController extends Controller
{
    public function broadcast(Request $request)
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
        if($request->request->get('channel_name') === 'private-App.User.' . $request->user()->id) {
            return $pusher->socket_auth($request->request->get('channel_name'), $request->request->get('socket_id'));
        }
        return response()->json([], 400);
    }
}
