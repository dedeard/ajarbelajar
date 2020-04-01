<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestedController extends Controller
{
    public function index(Request $request)
    {
        $requesteds = $request->user()->requestPosts()->select( ['id', 'user_id', 'category_id', 'requested_at', 'title', 'type'] )->whereNotNull('requested_at')->orderBy('requested_at', 'desc')->paginate(12);
        return view('web.dashboard.requested.index', ['requesteds' => $requesteds]);
    }

    public function destroy(Request $request, $id)
    {
        $post = $request->user()->requestPosts()->findOrFail($id);
        $post->requested_at = null;
        $post->save();
        return redirect()->back()->withSuccess('Berhasil Membatalkan permintaan.');
    }

    public function create(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->findOrFail($id);
        $article->requested_at = now();
        $article->save();

        if($article->type === 'article'){
            return redirect()->route('dashboard.requested.index')->withSuccess('Terimakasih.. Artikel anda segera akan kami tinjau untuk di publikasikan.');
        } else {
            return redirect()->route('dashboard.requested.index')->withSuccess('Terimakasih.. Video anda segera akan kami tinjau untuk di publikasikan.');
        }
    }
}