<?php

namespace App\Http\Controllers\Api\App;

use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Playlist;
use App\Notifications\FeedbackNotification;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
