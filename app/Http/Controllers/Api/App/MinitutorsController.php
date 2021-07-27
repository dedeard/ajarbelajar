<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinitutorResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostResource;
use App\Models\Minitutor;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MinitutorsController extends Controller
{
    public function index(Request $request)
    {
        $data = Cache::remember('minitutors.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            return Minitutor::with('user')
            ->withCount([
                'posts as video_count' => function($q){
                    $q->whereNotNull('posted_at')->where('type', 'video');
                },
                'posts as article_count' => function($q){
                    $q->whereNotNull('posted_at')->where('type', 'article');
                },
                'followers'
            ])
            ->where('active', true)
            ->orderByRaw('video_count + article_count  DESC')
            ->orderBy('id')
            ->paginate(12);
        });
        $data->getCollection()->transform(function($item){
            $user = $item->user;
            unset($item->user);
            unset($item->active);
            unset($item->reason);
            unset($item->expectation);
            return [
                'user' => UserResource::make($user),
                'minitutor' => $item,
            ];
        });
        return response()->json($data, 200);
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
            'followers' => $user->minitutor->followers()->get()->map(function($item){
                return UserResource::make($item->user);
            }),
            'videos' => PostResource::collection(Post::postListQuery($user->minitutor->videos())->get()),
            'articles' => PostResource::collection(Post::postListQuery($user->minitutor->articles())->get()),
        ];
    }
}
