<?php

namespace App\Http\Controllers\Web\MinitutorDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function index(Request $request)
    {
        $users = $request->user()->minitutor->subscribers();
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $users = $users->where('first_name', 'like', $search)->orWhere('last_name', 'like', $search)->orWhere('username', 'like', $search);
        }
        $users = $users->orderBy('pivot_created_at', 'desc')->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor-dashboard.followers', ['users' => $users]);
    }
}
