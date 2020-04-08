<?php

namespace App\Http\Controllers\Web\MyDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = $request->user()->activities()->select(['*'])->with(['post' => function($q){
            return $q->select(['id', 'title', 'hero', 'slug', 'type']);
        }])->orderBy('updated_at', 'desc')->get();
        return view('web.my-dashboard.activity', ['activities' => $activities]);
    }
}
