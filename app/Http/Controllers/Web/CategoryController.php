<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use Artesaos\SEOTools\Facades\SEOTools;

class CategoryController extends Controller
{
    public function index()
    {
        Seo::set('Category');
        $category = Category::has('posts')->withCount([
            'posts as article_count' => function($q){
                return $q->where('type', 'article')->where('draf', false);
            },
            'posts as video_count' => function($q){
                return $q->where('type', 'video')->where('draf', false);
            }
        ])->paginate(12);
        return view('web.category.index', ['categories' => $category]);
    }

    public function show($slug)
    {
        $query = Category::where('slug', $slug);
        if(!$query->exists()) return abort(404);
        $category = $query->first();
        $data['posts'] = Post::postType($category->posts(), null, false)->paginate(6);
        SEOTools::setTitle($category->name);
        SEOTools::setDescription($category->description);
        return view('web.category.show', $data);
    }
}
