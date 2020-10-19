<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Playlist;
use App\Notifications\FeedbackNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('minitutor:active')->only('index');
    }

    public function index(Request $request, $type, $id)
    {
        $target = null;
        $user = $request->user();
        $minitutor = $user->minitutor;

        if($type === 'article') {
            $target = $minitutor->articles()->where('draf', false)->findOrFail($id);
        } else if ($type === 'playlist') {
            $target = $minitutor->playlists()->where('draf', false)->findOrFail($id);
        }
        if (!$target) return abort(404);
        $limit = $request->input('limit');
        if (empty($limit) || ($limit > 15)) {
            $limit = 15;
        }

        $feedback = $target->feedback()
                        ->select(['*', DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')])
                        ->with(['user' => function($q){
                            $q->select(['id', 'name', 'avatar', 'username']);
                        }])
                        ->orderBy('id')
                        ->paginate($limit);

        $feedback->getCollection()->transform(function ($value) {
            return FeedbackResource::make($value);
        });

        return response()->json($feedback, 200);
    }

    public function store(Request $request, $type, $id)
    {
        $target = null;
        if($type === 'article') {
            $target = Article::where('draf', false)->findOrFail($id);
        } else if ($type === 'playlist') {
            $target = Playlist::where('draf', false)->findOrFail($id);
        }
        if (!$target) return abort(404);

        $user = $request->user();

        if($target->feedback()->where('user_id', $user->id)->exists()){
            return abort(403);
        }

        $data = $request->validate([
            'message' => 'required|string|min:3|max:600',
            'understand' => 'required|numeric|digits_between:1,5',
            'inspiring' => 'required|numeric|digits_between:1,5',
            'language_style' => 'required|numeric|digits_between:1,5',
            'content_flow' => 'required|numeric|digits_between:1,5',
            'sync_with_me' => 'required|boolean',
        ]);
        $data['user_id'] = $user->id;

        PointHelper::onReviewed($user);
        PointHelper::onMinitutorPostReviewed($target->minitutor->user, round(($data['understand'] + $data['inspiring'] + $data['language_style'] + $data['content_flow'])/4));

        $feedback = new Feedback($data);
        $target->feedback()->save($feedback);
        $target->minitutor->user->notify(new FeedbackNotification($feedback));
        return response()->json([], 200);
    }

    public function show(Request $request, $type, $id)
    {
        $target = null;
        if($type === 'article') {
            $target = Article::where('draf', false)->findOrFail($id);
        } else if ($type === 'playlist') {
            $target = Playlist::where('draf', false)->findOrFail($id);
        }
        if (!$target) return abort(404);

        $user = $request->user();
        $data = $target->feedback()->where('user_id', $user->id)->firstOrFail();
        return $data;
    }
}
