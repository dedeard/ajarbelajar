<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Post;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, $post_id)
    {
        $user = $request->user();
        $post = Post::whereNotNull('posted_at')->findOrFail($post_id);

        if(!$user->favorites()->where('post_id', $post_id)->exists()) {
            Favorite::create(['user_id' => $user->id, 'post_id' => $post_id]);
        }

        return response()->noContent();
    }

    public function destroy(Request $request, $post_id)
    {
        $user = $request->user();
        $post = Post::findOrFail($post_id);
        Favorite::where('user_id', $user->id)->where('post_id', $post_id)->delete();
        return response()->noContent();
    }
}
