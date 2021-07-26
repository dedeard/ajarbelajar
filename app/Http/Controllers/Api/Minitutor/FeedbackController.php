<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $minitutor = $user->minitutor;
        $feedback = $minitutor->feedback()->with('user')->orderBy('id', 'desc')->get()->map(function($item){
            $temp = $item->toArray();
            $temp['user'] = UserResource::make($item->user);
            return $temp;
        });
        return response()->json($feedback, 200);
    }
}
