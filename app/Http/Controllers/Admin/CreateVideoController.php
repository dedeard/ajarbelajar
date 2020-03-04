<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Video;
use App\Model\Category;
use App\Model\Minitutor;
use App\Model\User;
use Illuminate\Http\Request;

class CreateVideoController extends Controller
{
    public function index(Request $request)
    {
        $minitutors = Minitutor::select(['id', 'user_id', 'active'])->where('active', 1)->with(['user' => function($query){
            $query->select(['id', 'username'])->with(['profile' => function($query){
                $query->select(['id', 'user_id', 'first_name', 'last_name']);
            }]);
        }])->orderBy('id', 'desc')->get();

        $data = [];

        foreach($minitutors as $minitutor) {
            array_push($data, [
                'id' => $minitutor->id,
                'user_id' => $minitutor->user_id,
                'name' => $minitutor->user->name(),
                'username' => $minitutor->user->username
            ]);
        }

        return view('admin.video.create.index', ['minitutors' => $data]);
    }

    public function create($user_id)
    {
        $user = User::findOrFail($user_id);
        if(!$user->minitutor){
            return abort(404);
        }
        return view('admin.video.create.create', ['user' => $user]);
    }

    public function store(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        if(!$user->minitutor){
            return abort(404);
        }
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160'
        ]);

        $video = Video::create(['title' => $data['title'], 'user_id' => $user->id]);
        return redirect()->route('admin.video.edit', $video->id)->withSuccess('Video minitutor telah dibuat.');
    }
}
