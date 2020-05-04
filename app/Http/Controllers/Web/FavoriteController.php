<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function create(Request $request, $id)
    {
        $target = Post::where('draf', 0)->findOrFail($id);
        $user = $request->user();
        if(!$user->hasFavorited($target)) {
            $user->unfavorite($target);
            $user->favorite($target);
        }
        return redirect()->back()->withSuccess("Postingan telah ditambahkan ke daftar favorite");
    }
    public function destroy(Request $request, $id)
    {
        $target = Post::where('draf', 0)->findOrFail($id);
        $user = $request->user();
        if($user->hasFavorited($target)) {
            $user->unfavorite($target);
        }
        return redirect()->back()->withSuccess("Postingan telah dihapus dari daftar favorite");
    }
}
