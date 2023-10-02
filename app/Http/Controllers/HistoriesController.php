<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoriesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $histories = $user->histories()->with('episode.lesson')->orderBy('updated_at', 'desc')->get();

        return view('histories', compact('histories'));
    }
}
