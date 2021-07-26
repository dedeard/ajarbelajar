<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $data = $user->activities()->with(['post' => function($q){
            return Post::postListQuery($q);
        }])
        ->orderBy('updated_at', 'desc')
        ->get()
        ->map(function($item){
            $temp = $item->toArray();
            $temp['post'] = PostResource::make($item->post);
            return $temp;
        });
        return response()->json($data, 200);
    }
}
