<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use DB;
class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $minitutor = $user->minitutor;
        $feedback = $minitutor->feedback()
        ->with(['user', 'post' => function($q){
            $q->select('id', 'slug', 'title', 'type');
        }])
        ->whereHas('post', function($q){
            $q->whereNotNull('posted_at');
        })
        ->get()->map(function($item){
            $temp = $item->toArray();
            $temp['rating'] = $item->rating;
            $temp['user'] = UserResource::make($item->user);
            return $temp;
        });
        return response()->json($feedback, 200);
    }
}
