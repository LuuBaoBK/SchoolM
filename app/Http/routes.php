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

Route::get ('admin/adduser/admin', 'Admin\AdduserController@get_ad');
Route::post('admin/adduser/admin', 'Admin\AdduserController@store_ad');

Route::get ('admin/adduser/teacher', 'Admin\AdduserController@get_te');
Route::post('admin/adduser/teacher', 'Admin\AdduserController@store_te');


//Manage class

Route::get('admin/classinfo', 'Classes\ClassController@view');

Route::get('admin/form', 'Classes\ClassController@form');

Route::post('admin/save', 'Classes\ClassController@save');

Route::post('admin/update', 'Classes\ClassController@update');

Route::get('admin/delete/{id}', 'Classes\ClassController@delete');

Route::get('admin/edit/{id}', 'Classes\ClassController@edit');


//Manage student of class

Route::get('admin/studentclassinfo', 'StudentInClass\StudentInClassController@view');

Route::get('admin/studentclassform', 'StudentInClass\StudentInClassController@form');

Route::post('admin/studentclasssave', 'StudentInClass\StudentInClassController@save');

Route::post('admin/studentclassupdate', 'StudentInClass\StudentInClassController@update');

Route::get('admin/studentclassdelete/{class_id}/{student_id}', 'StudentInClass\StudentInClassController@delete');

Route::get('admin/studentclassedit/{class_id}/{student_id}', 'StudentInClass\StudentInClassController@edit');





Route::get('admin/adduser', [
	'middleware' => 'authrole',
	'uses' => 'Admin\AdduserController@index',
	]);

Route::post('admin/adduser', 'Admin\AdduserController@store');

Route::get('admin/adduser', 'Admin\AdduserController@index');
Route::post('admin/adduser', 'Admin\AdduserController@store');

Route::get('admin/addsubject', 'Admin\AddsubjectController@index');
Route::post('admin/addsubject', 'Admin\AddsubjectController@store');
Route::put('admin/addsubject', 'Admin\AddsubjectController@update');

Route::get('admin/editsubject', 'Admin\EditsubjectController@edit');
