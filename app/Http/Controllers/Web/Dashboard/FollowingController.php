<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function index(Request $request)
    {
        SEOTools::setTitle('Diikuti');
        $followings = $request->user()->subscriptions(Minitutor::class)->paginate(12);
        return view('web.dashboard.following.index', ['minitutors' => $followings]);
    }
}
