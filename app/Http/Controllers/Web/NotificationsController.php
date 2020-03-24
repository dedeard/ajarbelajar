<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('web.notifications', ['notifications' => $user->notifications()->paginate(3)]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
    }

    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
    }
}
