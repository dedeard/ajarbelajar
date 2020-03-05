<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcceptedController extends Controller
{
    public function index(Request $request)
    {
        $accepteds = $request
                    ->user()
                    ->posts()
                    ->select(['id', 'user_id', 'category_id', 'slug', 'draf', 'title', 'created_at', 'type'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
        return view('web.dashboard.accepted.index', ['accepteds' => $accepteds]);
    }
}
