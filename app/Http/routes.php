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
Route::get('/', 'Auth\MyAuthController@getview');
Route::post('auth/login', 'Auth\MyAuthController@authenticate');
Route::get('auth/logout', 'Auth\MyAuthController@logout');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard','Auth\MyAuthController@get_dashboard');
});


Route::group(['prefix' => 'admin','middleware' => 'authrole_ad'], function () {

	Route::get('dashboard', 'Admin\ProfileController@get_ad_dashboard' );
	Route::post('dashboard', 'Admin\ProfileController@edit_info' );
	Route::post('dashboard/changepassword', 'Admin\ProfileController@changepassword' );

	Route::group(['prefix'=>'manage-user', 'namespace' => 'Admin\UserManage'], function(){
		Route::get ('admin', 'AdminManageController@get_ad');
		Route::post('admin', 'AdminManageController@store_ad');
		Route::get ('admin/edit/{id}',  'AdminManageController@get_edit_form');
		Route::post ('admin/edit', 'AdminManageController@edit_ad');
		Route::get ('admin/edit/{id}/reset_password',  'AdminManageController@reset_password');

		Route::get ('teacher', 'TeacherManageController@get_te');
		Route::post('teacher', 'TeacherManageController@store_te');
		Route::get ('teacher/edit/{id}', 'TeacherManageController@get_edit_form');
		Route::post ('teacher/edit', 'TeacherManageController@edit_ad');
		Route::get ('teacher/edit/{id}/reset_password',  'TeacherManageController@reset_password');

		Route::get ('student', 'StudentManageController@get_stu');
		Route::post('student', 'StudentManageController@store_stu');
		Route::post('student/show', 'StudentManageController@show');
		Route::get ('student/edit/{id}', 'StudentManageController@get_edit_form');
		Route::post ('student/edit', 'StudentManageController@edit_stu');
		Route::get ('student/edit/{id}/reset_password',  'StudentManageController@reset_password');

		Route::get ('parent', 'ParentManageController@get_pa');
		Route::post('parent/show', 'ParentManageController@show');
		Route::post('parent/getdata', 'ParentManageController@getdata');
		Route::post('parent/edit', 'ParentManageController@editdata');
		Route::get ('parent/edit/{id}/reset_password',  'ParentManageController@reset_password');
	});
    
    //Manage class
	Route::group(['prefix' => 'class', 'namespace' =>'Admin\Classes'], function(){
		Route::get('classinfo', 'ClassController@view');
		Route::post('classinfo/search', 'ClassController@show');
		Route::post('classinfo/updateform', 'ClassController@updateform');
		Route::post('classinfo/store', 'ClassController@store');
		Route::get('classinfo/edit/{id}', 'ClassController@get_edit_form');
		Route::post('classinfo/edit/{id}', 'ClassController@changeinfo');

		//Manage student of class
		Route::get('studentclassinfo', 'StudentInClassController@view');
		Route::post('studentclassinfo/updateclassname', 'StudentInClassController@updateclassname');
		Route::post('studentclassinfo/showclass', 'StudentInClassController@showclass');
		Route::post('studentclassinfo/showstudent', 'StudentInClassController@showstudent');
		Route::post('studentclassinfo/addstudent', 'StudentInClassController@addstudent');
		Route::post('studentclassinfo/removestudent', 'StudentInClassController@removestudent');
	});
	
	//Manage subject
	Route::get('addsubject', 'Admin\AddsubjectController@getsubject');
	Route::post('addsubject', 'Admin\AddsubjectController@storesubject');

	Route::get('editsubject/{id}', 'Admin\EditsubjectController@edit');
	Route::post('editsubject{id}', 'Admin\EditsubjectController@update');
	Route::get('deletesubject/{id}', 'Admin\EditsubjectController@delete');

	Route::get('schedule', 'Admin\ScheduleController@index');
	Route::post('schedule/getschedule', 'Admin\ScheduleController@getschedule');
	Route::post('schedule', 'Admin\ScheduleController@store');

	Route::get('transcript', 'Admin\TranscriptController@index');
	Route::post('transcript', 'Admin\TranscriptController@store');
});

Route::group(['prefix' => 'teacher','middleware' => 'authrole_te'], function () {
	Route::get('dashboard', 'Teacher\ProfileController@get_te_dashboard' );

});

