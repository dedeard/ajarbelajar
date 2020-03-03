<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return view('web.category.index', ['categories' => Category::all()]);
    }

    public function show($slug)
    {
        $query = Category::where('slug', $slug);
        if(!$query->exists()) {
            return abort(404);
        }
        $category = $query->first();


        $article = $category->articles()->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', DB::raw('"article" as type'), ])->with(['user' => function($query){
            return $query->select(['id', 'username'])->with(['profile' => function($query){
                return $query->select(['user_id', 'first_name', 'last_name']);
            }]);
        }])->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->where('draf', false);

        $posts = $category->videos()->union($article)->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', DB::raw('"video" as type')])->with(['user' => function($query){
            return $query->select(['id', 'username'])->with(['profile' => function($query){
                return $query->select(['user_id', 'first_name', 'last_name']);
            }]);
        }])->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->where('draf', false);


        return view('web.category.show', ['posts' => $posts->paginate(6)]);
    }
}
