<?php

namespace App\Http\Controllers\Admin\Api;

use App\Helpers\EditorjsHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage article');
    }

    public function uploadImage(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $upload = EditorjsHelper::uploadImage($data['file']);
        $article->images()->save(new Image(['name' => $upload['name']]));
        return response()->json(['success' => 1, 'file' => $upload]);
    }
}
