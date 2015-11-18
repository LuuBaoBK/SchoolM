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
Route::get('/mypage',function(){return view('auth.mylogin');});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard','Auth\MyAuthController@get_dashboard');
});


Route::group(['prefix' => 'admin','middleware' => 'authrole_ad'], function () {

	Route::get('dashboard', 'Admin\ProfileController@get_ad_dashboard' );
	Route::post('dashboard', 'Admin\ProfileController@edit_info' );

	Route::group(['prefix'=>'manage-user', 'namespace' => 'Admin\UserManage'], function(){
		Route::get ('admin', 'AdminManageController@get_ad');
		Route::post('admin', 'AdminManageController@store_ad');
		Route::get ('admin/edit/{id}',  'AdminManageController@get_edit_form');
		Route::post ('admin/edit', 'AdminManageController@edit_ad');

		Route::get ('teacher', 'TeacherManageController@get_te');
		Route::post('teacher', 'TeacherManageController@store_te');
		Route::get ('teacher/edit/{id}', 'TeacherManageController@get_edit_form');
		Route::post ('teacher/edit', 'TeacherManageController@edit_ad');

		Route::get ('student', 'StudentManageController@get_stu');
		Route::post('student', 'StudentManageController@store_stu');
		Route::post('student/show', 'StudentManageController@show');
		Route::get ('student/edit/{id}', 'StudentManageController@get_edit_form');
		Route::post ('student/edit', 'StudentManageController@edit_stu');

		Route::get ('parent', 'ParentManageController@get_pa');
		Route::post('parent/show', 'ParentManageController@show');
		Route::post('parent/getdata', 'ParentManageController@getdata');
		Route::post('parent/edit', 'ParentManageController@editdata');
	});
    
    //Manage class
	Route::group(['prefix' => 'class'], function(){
		Route::get('classinfo', 'Classes\ClassController@view');
		Route::get('form', 'Classes\ClassController@form');
		Route::post('save', 'Classes\ClassController@save');
		Route::post('update', 'Classes\ClassController@update');
		Route::get('delete/{id}', 'Classes\ClassController@delete');
		Route::get('edit/{id}', 'Classes\ClassController@edit');

		//Manage student of class
		Route::get('class/studentclassinfo', 'StudentInClass\StudentInClassController@view');
		Route::post('filterstudent', 'StudentInClass\StudentInClassController@filterstudent');
		Route::post('getclass', 'StudentInClass\StudentInClassController@getclass');
		Route::post('addStudent', 'StudentInClass\StudentInClassController@addStudent');
		Route::post('removeStudent', 'StudentInClass\StudentInClassController@removeStudent');
	});
	
	//Manage subject
	Route::get('addsubject', 'Admin\AddsubjectController@getsubject');
	Route::post('addsubject', 'Admin\AddsubjectController@storesubject');

	Route::get('editsubject/{id}', 'Admin\EditsubjectController@edit');
	Route::post('editsubject{id}', 'Admin\EditsubjectController@update');
	Route::get('deletesubject/{id}', 'Admin\EditsubjectController@delete');

	Route::get('schedule', 'Admin\ScheduleController@index');
	Route::post('schedule', 'Admin\ScheduleController@store');

	Route::get('transcript', 'Admin\TranscriptController@index');
	Route::post('transcript', 'Admin\TranscriptController@store');
});

