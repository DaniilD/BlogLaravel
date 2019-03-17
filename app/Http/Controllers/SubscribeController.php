<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Subscription;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {		
    	$this->validate($request,[
    		'email'=>'required|email|unique:subscriptions'
    	]);

    	Subscription::add($request->get('email'));
    	
    	return redirect()->back()->with('status', 'Проверте ваш email');
    }
}
