<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::has('posts')->withCount([
            'posts as article_count' => function($q){
                return $q->where('type', 'article')->where('draf', false);
            },
            'posts as video_count' => function($q){
                return $q->where('type', 'video')->where('draf', false);
            }
        ]);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $category = $category->where('name', 'like', $search);
        }
        $category = $category->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.category.index', ['categories' => $category]);
    }

    public function show($slug)
    {
        $query = Category::where('slug', $slug);
        if(!$query->exists()) return abort(404);
        $category = $query->first();
        $data['posts'] = Post::postType($category->posts(), null, false)->paginate(6);
        SEOMeta::setTitle($category->name);
        SEOMeta::setRobots('noindex');
        return view('web.category.show', $data);
    }
}
