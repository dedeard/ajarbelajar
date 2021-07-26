<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinitutorResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class FollowingsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return $user->followings()->with('minitutor.user')->whereHas('minitutor', function($q){
            $q->where('active', true);
        })->get()->map(function($item){
            $temp = $item->toArray();
            $temp['minitutor'] = MinitutorResource::make($item->minitutor);
            $temp['user'] = UserResource::make($item->minitutor->user);
            return $temp;
        });
    }
}
