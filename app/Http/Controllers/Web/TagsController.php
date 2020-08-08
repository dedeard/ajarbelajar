<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tagged;

class TagsController extends Controller
{
    public function show($slug)
    {
        $tag = Tagged::where('tag_slug', $slug)->exists();
        if(!$tag) return abort(404);
        $posts = Post::posts()->whereHas('tagged', function($q) use ($slug){
            return $q->where('tag_slug', $slug);
        })->paginate(6);
        return view('web.tag', ['posts' => $posts]);
    }
}
