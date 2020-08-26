<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Playlist;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $data = $request->validate([
            'message' => 'required|string|min:3|max:600',
            'understand' => 'required|numeric|digits_between:1,5',
            'inspiring' => 'required|numeric|digits_between:1,5',
            'language_style' => 'required|numeric|digits_between:1,5',
            'content_flow' => 'required|numeric|digits_between:1,5',
            'sync_with_me' => 'required|boolean',
        ]);
        $data['user_id'] = $user->id;

        $feedback = new Feedback($data);
        $target->feedback()->save($feedback);

        return response()->json([], 200);
    }
}
