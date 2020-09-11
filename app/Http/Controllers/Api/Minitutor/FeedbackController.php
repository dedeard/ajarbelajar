<?php

namespace App\Http\Controllers\Api\minitutor;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
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
            $q->select('id', 'minitutor_id', 'draf')->with(['feedback' => function($q){
                $q->select(['*', DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')]);
                $q->with(['user' => function($q) {
                    $q->select('id', 'avatar', 'username', 'name');
                }]);
            }])->where('draf', false);
        };

        $feedback = [];
        $data = $request->user()->minitutor()->select('id')->with(['articles' => $with, 'playlists' => $with])->first();

        foreach ($data->articles as $article) {
            foreach($article->feedback as $obj) {
                $arr = $obj->toArray();
                $arr['type'] = 'Article';
                $arr['created_at'] = $obj->created_at->timestamp;
                array_push($feedback, $arr);
            }
        }
        foreach ($data->playlists as $playlist) {
            foreach($playlist->feedback as $obj) {
                $arr = $obj->toArray();
                $arr['type'] = 'Playlist';
                $arr['created_at'] = $obj->created_at->timestamp;
                array_push($feedback, $arr);
            }
        }

        $response = [];
        foreach ($feedback as $arr) {
                $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
                $arr['created_at'] = $obj->created_at->timestamp;
                unset($arr['feedbackable_type']);
                unset($arr['feedbackable_id']);
                unset($arr['user_id']);
                unset($arr['updated_at']);
                array_push($response, $arr);
        }

        return $response;
    }
}
