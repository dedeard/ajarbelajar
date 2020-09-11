<?php

namespace App\Http\Controllers\Api\minitutor;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'minitutor:active']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $with = function($q){
            $q->select('id', 'minitutor_id', 'draf')->with(['comments' => function($q){
                $q->with(['user' => function($q) {
                    $q->select('id', 'avatar', 'username', 'name');
                }])->where('public', true);
            }])->where('draf', false);
        };

        $comments = [];
        $data = $request->user()->minitutor()->select('id')->with(['articles' => $with, 'playlists' => $with])->first();

        foreach ($data->articles as $article) {
            foreach($article->comments as $comment) {
                $comment = $comment->toArray();
                $comment['type'] = 'Article';
                $comment['user']['avatar'] = AvatarHelper::getUrl($comment['user']['avatar']);
                $comment['created_at'] = Carbon::parse($comment['created_at'])->timestamp;
                unset($comment['commentable_type']);
                unset($comment['commentable_id']);
                unset($comment['user_id']);
                unset($comment['updated_at']);
                unset($comment['public']);
                array_push($comments, $comment);
            }
        }
        foreach ($data->playlists as $playlist) {
            foreach($playlist->comments as $comment) {
                $comment = $comment->toArray();
                $comment['type'] = 'Playlist';
                $comment['user']['avatar'] = AvatarHelper::getUrl($comment['user']['avatar']);
                $comment['created_at'] = Carbon::parse($comment['created_at'])->timestamp;
                unset($comment['commentable_type']);
                unset($comment['commentable_id']);
                unset($comment['user_id']);
                unset($comment['updated_at']);
                unset($comment['public']);
                array_push($comments, $comment);
            }
        }

        return $comments;
    }
}
