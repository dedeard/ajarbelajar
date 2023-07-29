<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $activities = $user->activities()->with('episode.lesson')->orderBy('updated_at', 'desc')->get();

        return view('dashboard/activities', compact('activities'));
    }
}
