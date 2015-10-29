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

Route::get('admin/userManage', function () {
    return view('adminpage.adduser');
});

// Authentication routes...
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'auth\AuthController@postLogin');
Route::get('auth/logout', 'auth\AuthController@getLogout');

// Registration routes...
Route::get('admin/adduser', function() {
	return view('adminpage.adduser');
});
Route::post('admin/adduser', 'Admin\adduser@store');