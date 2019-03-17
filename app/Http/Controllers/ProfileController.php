<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
class ProfileController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
    	return view('pages.profile',['user'=>$user]);
    }

    public function store(Request $request){
    	$user = Auth::user();
    	//dd($request->all());
    	$this->validate($request,[
    		'name'=>'required',
    		'email' => 'required|unique:users,email,' . $user->id,
    		//'password'=>'required',
    		'image'=>'image'
    	]);

    	$user->edit($request->all());
    	$user->uploadImage($request->file('image'));

    	return redirect()->back()->with('status','Ваш профиль успешно обнавлен');
    }
}
