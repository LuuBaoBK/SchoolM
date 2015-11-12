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
Route::get('/mypage',function(){
	return view('mytemplate.newblankpage');
});
Route::group(['prefix' => 'admin','middleware' => 'authrole_ad'], function () {

	Route::get('dashboard', function () {
	    return view('adminpage.dashboard');
	});

	Route::group(['prefix'=>'manage-user', 'namespace' => 'Admin\UserManage'], function(){
		Route::get ('admin', 'AdminManageController@get_ad');
		Route::post('admin', 'AdminManageController@store_ad');
		Route::get ('admin/edit/{id}', 'AdminManageController@get_edit_form');
		Route::post ('admin/edit', 'AdminManageController@edit_ad');

		Route::get ('teacher', 'TeacherManageController@get_te');
		Route::post('teacher', 'TeacherManageController@store_te');
		Route::get ('teacher/edit/{id}', 'TeacherManageController@get_edit_form');
		Route::post ('teacher/edit', 'TeacherManageController@edit_ad');

		Route::get ('student', 'StudentManageController@get_stu');
		Route::post('student', 'StudentManageController@store_stu');
		Route::post('student/show', 'StudentManageController@show');
		Route::get ('student/edit/{id}', 'StudentManageController@get_edit_form');
		Route::post ('student/edit/{id}', 'StudentManageController@edit_ad');

		Route::get ('parent', 'Admin\UserManageController@get_pa');
		Route::post('parent', 'Admin\UserManageController@store_pa');
		Route::get ('parent/edit/{id}', 'Admin\UserManageController@get_edit_form');
		Route::post ('parent/edit/{id}', 'Admin\UserManageController@edit_ad');

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

Route::get('admin/adduser', [
	'middleware' => 'authrole',
	'uses' => 'Admin\AdduserController@index',
	]);
Route::get ('admin/manage-user/admin', 'Admin\UserManageController@get_ad');
Route::post('admin/manage-user/admin', 'Admin\UserManageController@store_ad');
Route::get ('admin/manage-user/admin/delete/{id}', 'Admin\UserManageController@delete_ad');
Route::get ('admin/manage-user/admin/edit/{id}', 'Admin\UserManageController@get_edit_form');
Route::post ('admin/manage-user/admin/edit/{id}', 'Admin\UserManageController@edit_ad');

Route::get ('admin/manage-user/teacher', 'Admin\UserManageController@get_te');
Route::post('admin/manage-user/teacher', 'Admin\UserManageController@store_te');
Route::get ('admin/manage-user/teacher/delete/{id}', 'Admin\UserManageController@delete_te');

Route::get ('admin/manage-user/student', 'Admin\UserManageController@get_stu');
Route::post('admin/manage-user/student', 'Admin\UserManageController@store_stu');

Route::get ('admin/manage-user/parent', 'Admin\UserManageController@get_pa');
Route::post('admin/manage-user/parent', 'Admin\UserManageController@store_pa');

Route::get ('admin/manage-user/userlist', 'Admin\UserManageController@get_userlist');

//Manage class

Route::get('admin/classinfo', 'Classes\ClassController@view');

Route::get('admin/form', 'Classes\ClassController@form');

Route::post('admin/save', 'Classes\ClassController@save');

Route::post('admin/update', 'Classes\ClassController@update');

Route::get('admin/delete/{id}', 'Classes\ClassController@delete');

Route::get('admin/edit/{id}', 'Classes\ClassController@edit');


//Manage student of class

Route::get('studentclassinfo', 'StudentInClass\StudentInClassController@view');

Route::post('filterstudent', 'StudentInClass\StudentInClassController@filterstudent');

Route::post('getclass', 'StudentInClass\StudentInClassController@getclass');

Route::post('addStudent', 'StudentInClass\StudentInClassController@addStudent');

Route::post('removeStudent', 'StudentInClass\StudentInClassController@removeStudent');




Route::get('admin/adduser', [
	'middleware' => 'authrole',
	'uses' => 'Admin\AdduserController@index',
	]);

Route::post('admin/adduser', 'Admin\AdduserController@store');

Route::get('admin/adduser', 'Admin\AdduserController@index');
Route::post('admin/adduser', 'Admin\AdduserController@store');


//Manage subject
Route::get('admin/addsubject', 'Admin\AddsubjectController@index');
Route::post('admin/addsubject', 'Admin\AddsubjectController@store');


