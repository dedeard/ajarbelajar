<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $minitutor = $user->minitutor;
        $comments = $minitutor->comments()->with('user')->where('public', true)->orderBy('id', 'desc')->get();
        return response()->json(CommentResource::collection($comments), 200);
    }
}
