<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Tag;
use App\Category;

class HomeController extends Controller
{
    public function index()
    {
    	$posts = Post::paginate(2);
        $post = Post::find(57);
        //dd($post->author);
    	return view('pages.index',[
    		'posts'=>$posts
 		]);
    }

    public function show($slug){
    	$post=Post::where('slug',$slug)->firstOrFail();

    	return view('pages.show',['post'=>$post]);
    }

    public function tag($slug){
    	$tag = Tag::where('slug',$slug)->firstOrFail();


    	$posts = $tag->posts()->paginate(2);

    	return view('pages.list',['posts'=>$posts]);

    }

    public function category($slug){

    	$category = Category::where('slug',$slug)->firstOrFail();

    	$posts = $category->posts()->paginate(2);

    	return view('pages.list',['posts'=>$posts]);

    }

}
