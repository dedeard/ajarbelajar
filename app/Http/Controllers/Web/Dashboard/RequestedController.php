<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestedController extends Controller
{
    public function index(Request $request)
    {
        $articles = $request->user()->requestArticles()->select( ['id', 'user_id', 'category_id', 'requested_at', 'title', DB::raw('"article" as type')])->whereNotNull('requested_at');
        $requesteds = $request->user()->requestVideos()->union($articles)->select( ['id', 'user_id', 'category_id', 'requested_at', 'title', DB::raw('"video" as type')] )->whereNotNull('requested_at')->orderBy('requested_at', 'desc')->paginate(12);
        return view('web.dashboard.requested.index', ['requesteds' => $requesteds]);
    }

    public function destroy(Request $request, $id, $type)
    {
        if($type === 'article'){
            $article = $request->user()->requestArticles()->findOrFail($id);
            $article->requested_at = null;
            $article->save();
        } else {
            $video = $request->user()->requestVideos()->findOrFail($id);
            $video->requested_at = null;
            $video->save();
        }
        return redirect()->back()->withSuccess('Berhasil Membatalkan permintaan.');
    }

    public function create(Request $request, $id, $type)
    {
        if($type === 'article'){
            $article = $request->user()->requestArticles()->findOrFail($id);
            $article->requested_at = now();
            $article->save();
            return redirect()->back()->withSuccess('Terimakasih.. Artikel anda segera akan kami tinjau untuk di publikasikan.');
        } else {
            $video = $request->user()->requestVideos()->findOrFail($id);
            $video->requested_at = now();
            $video->save();
            return redirect()->back()->withSuccess('Terimakasih.. Video anda segera akan kami tinjau untuk di publikasikan.');
        }
    }
}