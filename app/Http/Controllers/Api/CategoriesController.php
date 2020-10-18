<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount([
            'articles' => function($q){
                $q->where('draf', false);
            },
            'playlists' => function($q){
                $q->where('draf', false);
            },
        ])->get();
        $response = [];

        foreach($categories as $category) {
            $arr = $category->toArray();
            $arr['created_at'] = $category->created_at->timestamp;
            $arr['updated_at'] = $category->updated_at->timestamp;
            array_push($response, $arr);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $response = [];
        $articles = Article::generateQuery($category->articles())->get()->toArray();
        foreach($articles as $article) {
            $arr = $article;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['type'] = 'Article';
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        $playlists = Playlist::generateQuery($category->playlists())->get()->toArray();
        foreach($playlists as $playlist) {
            $arr = $playlist;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['type'] = 'Playlist';
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return $response;
    }

    public function popular() {
        $categories = Category::withCount([
            'articles' => function($q){
                $q->where('draf', false);
            },
            'playlists' => function($q){
                $q->where('draf', false);
            },
        ])
        ->orderBy(DB::raw("`playlists_count` + `articles_count`"), 'desc')
        ->limit(4)
        ->get();
        $response = [];

        foreach($categories as $category) {
            $arr = $category->toArray();
            $arr['created_at'] = $category->created_at->timestamp;
            $arr['updated_at'] = $category->updated_at->timestamp;
            array_push($response, $arr);
        }
        return $response;
    }
}
