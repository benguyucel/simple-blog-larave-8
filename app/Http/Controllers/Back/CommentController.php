<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderBy('created_at', 'DESC')->get();
        return view('back.comment.index', compact('comments'));
    }

    public function changeStatus(Request $request)
    {
       
        $changeStatus = Comment::findOrFail($request->id);
        $changeStatus->status = $request->status == "true" ? 1 : 0;
        $changeStatus->save();
    }
}
