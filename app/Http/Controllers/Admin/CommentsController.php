<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coments = Comment::all();

        return view('admin.comments.index',['comments'=>$coments]);
    }


    public function toggle($id)
    {
        $comment = Comment::find($id);

        $comment->toggleStatus();

        return redirect()->back();

    }

    public function destroy($id)
    {
        Comment::find($id)->delete();

        return redirect()->back();
    }

    
}
