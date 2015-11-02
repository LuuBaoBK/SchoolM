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

Route::get('admin/dashboard', function () {
    return view('adminpage.dashboard');
});

// Authentication routes...
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\MyAuthController@authenticate');
Route::get('auth/logout', 'Auth\MyAuthController@logout');

// Registration routes...
Route::get('admin/adduser', [
	'middleware' => 'authrole',
	'uses' => 'Admin\AdduserController@index',
	]);
Route::post('admin/adduser', 'Admin\AdduserController@store');