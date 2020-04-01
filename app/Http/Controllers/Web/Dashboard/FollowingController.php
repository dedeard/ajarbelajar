<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function index(Request $request)
    {
        Seo::set('Dashboard Following');
        $followings = $request->user()->subscriptions(Minitutor::class)->paginate(12);
        return view('web.dashboard.following.index', ['minitutors' => $followings]);
    }
}
