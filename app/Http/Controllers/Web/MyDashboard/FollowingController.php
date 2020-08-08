<?php

namespace App\Http\Controllers\Web\MyDashboard;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function index(Request $request)
    {
        $followings = $request->user()->subscriptions(Minitutor::class);

        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $followings = $followings->whereHas('user', function($q) use($search) {
                $q->where('first_name', 'like', $search)
                ->orWhere('last_name', 'like', $search)
                ->orWhere('username', 'like', $search);
            });
        }

        $followings = $followings->where('active', 1)->paginate(12)->appends(['search' => $request->input('search')]);

        return view('web.my-dashboard.following', ['followings' => $followings]);
    }
}
