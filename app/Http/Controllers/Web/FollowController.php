<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(Request $request, $id)
    {
        $target_user = User::findOrFail($id); 
        if(!$target_user->minitutor || $target_user->minitutor && !$target_user->minitutor->active) {
            return abort(404);
        }
        if($request->user()->hasSubscribed($target_user->minitutor)){
            return abort(404);
        }
        $request->user()->subscribe($target_user->minitutor);
        return redirect()->back()->withSuccess('Berhasil mengikuti MiniTutor');
    }
    public function unFollow(Request $request, $id)
    {
        $target_user = User::findOrFail($id); 
        if(!$target_user->minitutor || $target_user->minitutor && !$target_user->minitutor->active) {
            return abort(404);
        }
        if(!$request->user()->hasSubscribed($target_user->minitutor)){
            return abort(404);
        }
        $request->user()->unsubscribe($target_user->minitutor);
        return redirect()->back()->withSuccess('Anda telah berhanti mengikuti MiniTutor');
    }
}
