<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcceptedController extends Controller
{
    public function index(Request $request)
    {
        $articles = $request->user()->articles()->select( ['id', 'user_id', 'category_id', 'slug', 'draf', 'title', 'created_at', DB::raw('"article" as type')]);
        $accepteds = $request->user()->videos()->union($articles)->select( ['id', 'user_id', 'category_id', 'slug', 'draf', 'title', 'created_at', DB::raw('"video" as type')])->orderBy('created_at', 'desc')->paginate(12);
        return view('web.dashboard.accepted.index', ['accepteds' => $accepteds]);
    }
}
