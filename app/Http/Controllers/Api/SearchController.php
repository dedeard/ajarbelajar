<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::generateQuery(Article::query())->get()->toArray();
        $playlists = Playlist::generateQuery(Playlist::query())->orderBy('id', 'desc')->get()->toArray();
        $response = [];

        foreach($playlists as $playlist) {
            $arr = [
                'title' => $playlist['title'],
                'slug' => $playlist['slug'],
                'created_at' => Carbon::parse($playlist['created_at'])->timestamp,
                'img' => HeroHelper::getUrl($playlist['hero'] ? $playlist['hero']['name'] : null)['small'],
                'name' => $playlist['minitutor']['user']['name'],
                'type' => 'Playlist'
            ];
            array_push($response, $arr);
        }

        foreach($articles as $article) {
            $arr = [
                'title' => $article['title'],
                'slug' => $article['slug'],
                'created_at' => Carbon::parse($article['created_at'])->timestamp,
                'img' => HeroHelper::getUrl($article['hero'] ? $article['hero']['name'] : null)['small'],
                'name' => $article['minitutor']['user']['name'],
                'type' => 'Article'
            ];
            array_push($response, $arr);
        }

        return $response;
    }
}
