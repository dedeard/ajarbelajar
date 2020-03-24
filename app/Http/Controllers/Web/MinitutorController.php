<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\User;
use Artesaos\SEOTools\Facades\SEOTools;

class MinitutorController extends Controller
{
    public function index()
    {
        Seo::set('Minitutor');
        $minitutors = Minitutor::where('active', 1)->paginate(20);
        return view('web.minitutor.index', ['minitutors' => $minitutors]);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->first();
        
        if(!$user) return abort(404);
        if(!$user->minitutor) return abort(404);
        if(!$user->minitutor->active) return abort(404);

        SEOTools::setTitle('Minitutor ' . $user->name());
        SEOTools::setDescription($user->about);

        $posts = $user->posts()
                    ->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', 'type'])
                    ->with(['user' => function($query){
                        return $query->select(['id', 'username', 'first_name', 'last_name']);
                    }, 'reviews' => function($q){
                        return $q->select(['post_id', 'rating']);
                    }])
                    ->withCount(['comments' => function($query){
                        return $query->where('approved', true);
                    }, 'views'])->where('draf', false);

        return view('web.minitutor.show', ['user' => $user, 'posts' => $posts->paginate(12)]);
    }
}
