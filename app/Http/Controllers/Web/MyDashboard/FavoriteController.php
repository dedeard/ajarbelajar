<?php

namespace App\Http\Controllers\Web\MyDashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = Post::postType($request->user()->favorites(Post::class));
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $favorites = $favorites->where('title', 'like', $search)->orWhere('description', 'like', $search);
        }
        $favorites = $favorites->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.my-dashboard.favorite', ['favorites' => $favorites]);
    }
}
