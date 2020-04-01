<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function index(Request $request)
    {
        $followers = $request->user()->minitutor->subscribers()->orderBy('pivot_created_at', 'desc')->paginate(12);
        return view('web.dashboard.followers.index', ['followers' => $followers]);
    }
}
