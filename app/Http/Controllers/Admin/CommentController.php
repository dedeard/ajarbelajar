<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = PostComment::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.comment.index', ['comments' => $comments]);
    }

    public function approveToggle($id)
    {
        $comment = PostComment::findOrFail($id);
        if ($comment->approved) {
            $comment->approved = 0;
            $message = "Komentar tidak ditampilkan secara publik";
        } else {
            $comment->approved = 1;
            $message = "Komentar ditampilkan secara publik";
        }
        $comment->save();
        return redirect()->back()->withSuccess($message);
    }
}
