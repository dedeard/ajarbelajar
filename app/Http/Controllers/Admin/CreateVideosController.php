<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Minitutor;
use App\Model\User;
use Illuminate\Http\Request;

class CreateVideosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage post']);
    }
    public function index(Request $request)
    {
        $minitutors = Minitutor::select(['id', 'user_id', 'active'])->where('active', 1);

        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $minitutors = $minitutors->whereHas('user', function($q) use($search) {
                $q->select(['id', 'first_name', 'last_name', 'username', 'email'])
                ->where('first_name', 'like', $search)
                ->orWhere('last_name', 'like', $search)
                ->orWhere('username', 'like', $search)
                ->orWhere('email', 'like', $search);
            });
        }

        $minitutors = $minitutors->where('active', 1)->with(['user' => function($query){
            $query->select(['id', 'username', 'first_name', 'last_name']);
        }])->orderBy('id', 'desc')->get();

        return view('admin.video.create.index', ['minitutors' => $minitutors]);
    }

    public function create($id)
    {
        $minitutor = Minitutor::findOrFail($id);
        return view('admin.video.create.create', ['user' => $minitutor->user]);
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

        $video = Post::create(['type' => 'video', 'title' => $data['title'], 'user_id' => $user->id]);
        return redirect()->route('admin.videos.edit', $video->id)->withSuccess('Video minitutor telah dibuat.');
    }
}
