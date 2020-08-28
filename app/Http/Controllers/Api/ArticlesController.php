<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
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
    public function show(Request $request, $id)
    {
        $article = Article::generateQuery(Article::query(), true)->findOrFail($id);

        $arr = $article->toArray();
        $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
        $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
        $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
        $arr['minitutor']['created_at'] = Carbon::parse($arr['minitutor']['created_at'])->timestamp;
        $arr['minitutor']['updated_at'] = Carbon::parse($arr['minitutor']['updated_at'])->timestamp;
        $arr['user'] = $arr['minitutor']['user'];
        $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
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
}
