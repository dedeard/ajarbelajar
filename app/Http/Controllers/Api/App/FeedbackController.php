<?php

namespace App\Http\Controllers\Api\App;

use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Post;
use App\Notifications\FeedbackNotification;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, $post_id)
    {
        $user = $request->user();
        $target = Post::whereNotNull('posted_at')->findOrFail($post_id);

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
        return response()->noContent();
    }

    public function show(Request $request, $post_id)
    {
        $user = $request->user();
        $target = Post::whereNotNull('posted_at')->findOrFail($post_id);
        $data = $target->feedback()->where('user_id', $user->id)->firstOrFail();
        return $data;
    }
}
