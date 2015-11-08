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



// Authentication routes...
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\MyAuthController@authenticate');
Route::get('auth/logout', 'Auth\MyAuthController@logout');

Route::group(['prefix' => 'admin','middleware' => 'authrole_ad'], function () {

	Route::get('dashboard', function () {
	    return view('adminpage.dashboard');
	});

	Route::group(['prefix'=>'manage-user'], function(){
		Route::get ('admin', 'Admin\UserManageController@get_ad');
		Route::post('admin', 'Admin\UserManageController@store_ad');
		Route::get ('admin/delete/{id}', 'Admin\UserManageController@delete_ad');
		Route::get ('admin/edit/{id}', 'Admin\UserManageController@get_edit_form');
		Route::post ('admin/edit/{id}', 'Admin\UserManageController@edit_ad');

		Route::get ('teacher', 'Admin\UserManageController@get_te');
		Route::post('teacher', 'Admin\UserManageController@store_te');
		Route::get ('teacher/delete/{id}', 'Admin\UserManageController@delete_te');

		Route::get ('student', 'Admin\UserManageController@get_stu');
		Route::post('student', 'Admin\UserManageController@store_stu');

		Route::get ('parent', 'Admin\UserManageController@get_pa');
		Route::post('parent', 'Admin\UserManageController@store_pa');

		Route::get ('userlist', 'Admin\UserManageController@get_userlist');
	});
    
    //Manage class

	Route::get('classinfo', 'Classes\ClassController@view');
	Route::get('form', 'Classes\ClassController@form');
	Route::post('save', 'Classes\ClassController@save');
	Route::post('update', 'Classes\ClassController@update');
	Route::get('delete/{id}', 'Classes\ClassController@delete');
	Route::get('edit/{id}', 'Classes\ClassController@edit');

	//Manage subject
	Route::get('addsubject', 'Admin\AddsubjectController@index');
	Route::post('addsubject', 'Admin\AddsubjectController@store');

	Route::get('editsubject/{id}', 'Admin\EditsubjectController@edit');
	Route::post('editsubject{id}', 'Admin\EditsubjectController@update');
	Route::get('deletesubject/{id}', 'Admin\EditsubjectController@delete');

	Route::get('schedule', 'Admin\ScheduleController@index');
	Route::post('schedule', 'Admin\ScheduleController@store');

	Route::get('transcript', 'Admin\TranscriptController@index');
	Route::post('transcript', 'Admin\TranscriptController@store');
});




