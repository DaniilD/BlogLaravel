<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\Category;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('title','id')->all();
        $category = Category::pluck('title','id')->all();
    
        return view('admin.posts.create',['tags'=>$tags,'category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>"required",//обязательно
            'content'=>"required",
            'date'=>"required",
            'image'=>"image",
        ]);

        $post = Post::add($request->all());
        $post->uploadImage($request->file('image'));
        $post->setCategory($request->get('category_id'));
        $post->setTags($request->get('tags'));
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('is_featured'));

        return redirect('admin\posts');
    }

  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $tags = Tag::pluck('title','id')->all();
        $category = Category::pluck('title','id')->all();
        
        return view('admin.posts.edit',['post'=>$post,'tags'=>$tags,'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
     $this->validate($request,[
         'title'=>"required",//обязательно
         'content'=>"required",
         'date'=>"required",
         'image'=>"image",
     ]);

     $post = Post::find($id);
     $post->edit($request->all());
     $post->uploadImage($request->file('image'));
     $post->setCategory($request->get('category_id'));
     $post->setTags($request->get('tags'));
     $post->toggleStatus($request->get('status'));
     $post->toggleFeatured($request->get('is_featured'));

     return redirect('admin\posts');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->remove();
        return redirect('admin\posts');
    }
}
