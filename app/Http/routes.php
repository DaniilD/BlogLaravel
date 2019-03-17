<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Group for admin
Route::group([
	'middleware' => 'admin'
], function(){
	Route::get('/admin', 'Admin\DashboardController@index');
	Route::resource('admin/categories', 'Admin\CategoriesController');
	Route::resource('admin/tags', 'Admin\TagsController');
	Route::resource('admin/users', 'Admin\UsersController');
	Route::resource('admin/posts', 'Admin\PostsController');
	Route::get('admin/comments', 'Admin\CommentsController@index');
	Route::get('admin/comments/toggle/{id}', 'Admin\CommentsController@toggle');
	Route::delete('admin/comments/{id}/destroy', 'Admin\CommentsController@destroy')->name('admin.comments.destroy');

});

//Group for guest
Route::group([
	'middleware' => 'guest'
],function(){
	//register
	Route::get('register','AuthController@registerForm');
	Route::post('register','AuthController@register');

	//login
	Route::get('login','AuthController@loginForm');
	Route::post('login','AuthController@login');
});


//Group for users
Route::group([
	'middleware'=>'auth'
], function(){
	//logout
	Route::get('logout', 'AuthController@logout');
	Route::get('myprofile','ProfileController@index');
	Route::post('myprofile','ProfileController@store');
	Route::post('comment', 'CommentsController@store');
});


Route::get('/', 'HomeController@index');
Route::get('/post/{slug}','HomeController@show')->name('post.show');
Route::get('/tag/{slug}','HomeController@tag')->name('tag.show');
Route::get('/category/{slug}','HomeController@category')->name('category.show');
Route::post('/subscribe','SubscribeController@subscribe');






