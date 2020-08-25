<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage commet']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Daftar Komentar');
        $comments = Comment::orderBy('id', 'desc')->paginate(25);
        return view('comments.index', ['comments' => $comments]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Komentar telah dihapus.');
    }

    /**
     * make comment public.
     */
    public function makePublic($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['public' => true]);
        return redirect()->back()->withSuccess('Komentar telah dipublikasikan.');
    }
}
