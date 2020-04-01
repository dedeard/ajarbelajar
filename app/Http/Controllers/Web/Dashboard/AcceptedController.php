<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Request;

class AcceptedController extends Controller
{
    public function index(Request $request)
    {
        $accepteds = Post::postType($request->user()->posts(), null, null)->paginate(12);
        return view('web.dashboard.accepted.index', ['accepteds' => $accepteds]);
    }
}
