<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::generateQuery(Article::query())->get()->toArray();
        $response = [];
        foreach($articles as $article) {
            $arr = $article;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::generateQuery(Article::query(), true)->where('slug', $slug)->firstOrFail();
        $minitutor = $article->minitutor;

        if($user = auth('api')->user()) {
            $q = $article->activities()->where('user_id', $user->id);
            if ($q->exists()){
                $activity = $q->first();
                $activity->updated_at = now();
                $activity->save();
            } else {
                $activity = new Activity([ 'user_id' => $user->id ]);
                $article->activities()->save($activity);
                if($user->activities()->count() > 8) {
                    $user->activities()->orderBy('updated_at', 'asc')->first()->delete();
                }
            }
        }


        $latesArticles = $minitutor->articles()
        ->select(['minitutor_id', 'id', 'title', 'slug', 'draf', 'created_at'])
        ->where('draf', false)
        ->orderBy('id', 'desc')
        ->take(4)
        ->get()
        ->toArray();

        $latesPlaylists = $minitutor->playlists()
        ->select(['minitutor_id', 'id', 'title', 'slug', 'draf', 'created_at'])
        ->where('draf', false)
        ->orderBy('id', 'desc')
        ->take(4)
        ->get()
        ->toArray();

        $lates = [];
        foreach($latesArticles as $arr) {
            array_push($lates, [
                'id' => $arr['id'],
                'title' => $arr['title'],
                'slug' => $arr['slug'],
                'created_at' => Carbon::parse($arr['created_at'])->timestamp,
                'type' => 'Article'
            ]);
        }
        foreach($latesPlaylists as $arr) {
            array_push($lates, [
                'id' => $arr['id'],
                'title' => $arr['title'],
                'slug' => $arr['slug'],
                'created_at' => Carbon::parse($arr['created_at'])->timestamp,
                'type' => 'Playlist'
            ]);
        }

        $arr = $article->toArray();

        $description = null;
        $body = $arr['body'] ? json_decode($arr['body']) : null;
        if($body && isset($body->blocks)) {

            foreach ($body->blocks as $block) {
                if(!$description && $block->type === 'paragraph' && strlen($block->data->text) > 30){
                    $description = substr($block->data->text, 0, 160);
                }
            }
        }

        $arr['lates'] = $lates;
        $arr['description'] = $arr['description'] ?? $description;
        $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
        $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
        $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
        $arr['minitutor']['created_at'] = Carbon::parse($arr['minitutor']['created_at'])->timestamp;
        $arr['minitutor']['updated_at'] = Carbon::parse($arr['minitutor']['updated_at'])->timestamp;
        $arr['user'] = $arr['minitutor']['user'];
        $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
        $arr['rating'] = round($arr['rating'], 2);
        unset($arr['minitutor']['user']);

        $comments = [];
        foreach($arr['comments'] as $comment){
            $data = [
                'id' => $comment['id'],
                'body' => $comment['body'],
                'user' => $comment['user'],
                'created_at' => Carbon::parse($comment['created_at'])->timestamp,
            ];
            $data['user']['avatar'] = AvatarHelper::getUrl($data['user']['avatar']);
            array_push($comments, $data);
        }
        $arr['comments'] = $comments;

        return response()->json($arr, 200);
    }

    public function storeView(Request $request, $id)
    {
        $article = Article::where('draf', false)->whereHas('minitutor', function($q){
            $q->where('active', true);
        })->findOrFail($id);

        $view = null;
        if($user = auth('api')->user()) {
            $view = new View([
                'user_id' => $user->id,
                'ip' => $request->getClientIp() ?? '',
                'agent' => $request->header('User-Agent') ?? ''
            ]);
        } else {
            $view = new View([
                'ip' => $request->getClientIp() ?? '',
                'agent' => $request->header('User-Agent') ?? ''
            ]);
        }
        $article->views()->save($view);
        return response()->json([], 200);
    }

    public function popular()
    {
        $articles = Article::generateQuery(Article::query())->orderBy('views_count', 'desc')->limit(5)->get()->toArray();
        $response = [];
        foreach($articles as $article) {
            $arr = $article;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return response()->json($response, 200);
    }

    public function news()
    {
        $articles = Article::generateQuery(Article::query())->orderBy('id', 'desc')->limit(4)->get()->toArray();
        $response = [];
        foreach($articles as $article) {
            $arr = $article;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return response()->json($response, 200);
    }
}
