<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MinitutorResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\PostResource;
use App\Models\Minitutor;
use App\Models\User;
use App\Models\Playlist;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MinitutorsController extends Controller
{
    public function index(Request $request)
    {
        $data = Cache::remember('minitutors.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            return Minitutor::with('user')
            ->withCount([
                'playlists' => function($q){
                    $q->where('draf', false);
                },
                'articles' => function($q){
                    $q->where('draf', false);
                },
                'subscribers as followers_count'
            ])
            ->where('active', true)
            ->orderByRaw('articles_count + playlists_count  DESC')
            ->orderBy('id')
            ->paginate(12);
        });
        $data->getCollection()->transform(function($item){
            return [
                'user' => UserResource::make($item->user),
                'minitutor' => MinitutorResource::make($item),
            ];
        });
        return $data;
    }

    public function show($username)
    {
        $user = User::whereHas('minitutor' , function($q){
            $q->where('active', true);
        })
        ->where('username', $username)
        ->firstOrFail();
        return [
            'user' => UserResource::make($user),
            'minitutor' => MinitutorResource::make($user->minitutor),
            'followers' => UserResource::collection($user->minitutor->subscribers),
            'playlists' => PostResource::collection(Playlist::postListQuery($user->minitutor->playlists())->get()),
            'articles' => PostResource::collection(Article::postListQuery($user->minitutor->articles())->get()),
        ];
    }
}
