<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request){
        return abort(404);
    }

    private function getUser($username)
    {
        return User::where('username', $username)->firstorfail();
    }

    public function activity($username)
    {
        $user = $this->getUser($username);
        $activities = $user->activities()->select(['*'])->with(['post' => function($q){
            return $q->select(['id', 'title', 'hero', 'slug', 'type']);
        }])->orderBy('updated_at', 'desc')->get();
        return view('web.users.activity', ['activities' => $activities, 'user' => $user]);
    }

    public function favorite(Request $request, $username)
    {
        $user = $this->getUser($username);
        $favorites = Post::postType($user->favorites(Post::class));
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $favorites = $favorites->where('title', 'like', $search)->orWhere('description', 'like', $search);
        }
        $favorites = $favorites->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.users.favorite', ['favorites' => $favorites, 'user' => $user]);
    }

    public function following(Request $request, $username)
    {
        $user = $this->getUser($username);
        $followings = $user->subscriptions(Minitutor::class);

        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $followings = $followings->whereHas('user', function($q) use($search) {
                $q->where('first_name', 'like', $search)
                ->orWhere('last_name', 'like', $search)
                ->orWhere('username', 'like', $search);
            });
        }
        $followings = $followings->where('active', 1)->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.users.following', ['followings' => $followings, 'user' => $user]);
    }
}
