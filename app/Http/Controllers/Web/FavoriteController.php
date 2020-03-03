<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Video;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function create(Request $request, $id, $type)
    {
        if($type === 'article'){
            $target = Article::where('draf', 0)->findOrFail($id);
            $message = "Artikel telah ditambahkan ke daftar Favorite";
        }else {
            $target = Video::where('draf', 0)->findOrFail($id);
            $message = "Video telah ditambahkan ke daftar Favorite";
        }
        $user = $request->user();
        if(!$user->hasFavorited($target)) {
            $user->unfavorite($target);
            $user->favorite($target);
        }
        return redirect()->back()->withSuccess($message);
    }
    public function destroy(Request $request, $id, $type)
    {
        if($type === 'article'){
            $target = Article::where('draf', 0)->findOrFail($id);
            $message = "Artikel telah dihapus dari daftar Favorite";
        }else {
            $target = Video::where('draf', 0)->findOrFail($id);
            $message = "Video telah dihapus dari daftar Favorite";
        }

        $user = $request->user();
        if($user->hasFavorited($target)) {
            $user->unfavorite($target);
        }

        return redirect()->back()->withSuccess($message);
    }
}
