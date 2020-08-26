<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
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
        $user = $request->user();
        $minitutor = $user->minitutor;
        $articles = $minitutor->articles();
        return response()->json(ArticleResource::collection(Article::generateQuery($articles, false, true)->get()), 200);
    }
}
