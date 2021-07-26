<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\MinitutorResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = Cache::remember('users.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            return UserResource::collection(User::orderBy('points', 'desc')->orderBy('id')->paginate(20));
        });
        return $users;
    }

    public function show($id)
    {
        $user = User::where('id', $id)->orWhere('username', $id)->firstOrFail();
        $data = [
            'user' => UserResource::make($user),
            'favorites' => $user->favorites()->with(['post' => function($q){
                return Post::postListQuery($q);
            }])->get()->map(function($item){
                return [
                    'id' => $item->id,
                    'created_at' => $item->created_at,
                    'post' => PostResource::make($item->post)
                ];
            }),
            'followings' => $user->followings()->with(['minitutor' => function($q){
                return $q->where('active', true)->with('user');
            }])->get()->map(function($item){
                return [
                    'id' => $item->id,
                    'created_at' => $item->created_at,
                    'user' => UserResource::make($item->minitutor->user),
                    'minitutor' => MinitutorResource::make($item->minitutor),
                ];
            })
        ];
        return $data;
    }

    public function mostPoints()
    {
        $users = Cache::remember('users.most.points', config('cache.age'), function () {
            return UserResource::collection(User::orderBy('points', 'desc')->limit(4)->get());
        });
        return $users;
    }
}
