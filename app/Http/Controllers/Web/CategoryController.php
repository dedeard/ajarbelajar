<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::withCount([
            'posts as article_count' => function($q){
                return $q->where('type', 'article')->where('draf', false);
            },
            'posts as video_count' => function($q){
                return $q->where('type', 'video')->where('draf', false);
            },
        ])->get();
        return view('web.category.index', ['categories' => $category]);
    }

    public function show($slug)
    {
        $query = Category::where('slug', $slug);
        if(!$query->exists()) {
            return abort(404);
        }
        $category = $query->first();


        $posts = $category->posts()
                ->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', 'type'])
                ->with(['user' => function($query){
                    return $query->select(['id', 'username'])->with(['profile' => function($query){
                        return $query->select(['user_id', 'first_name', 'last_name']);
                    }]);
                }])
                ->withCount(['comments' => function($query){
                    return $query->where('approved', true);
                }, 'views'])
                ->where('draf', false);


        return view('web.category.show', ['posts' => $posts->paginate(6)]);
    }
}
