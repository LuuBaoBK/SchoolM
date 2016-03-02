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
Route::get('/test', 'Test\TestController@test');
Route::post('/test', 'Test\TestController@test_read');
Route::post('/test/read', 'Test\TestController@test_read');
Route::post('auth/login', 'Auth\MyAuthController@authenticate');
Route::get('auth/logout', 'Auth\MyAuthController@logout');

// Error Route
Route::get('permission_denied', 'Auth\MyAuthController@permission_denied');


//common route
Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard','Auth\MyAuthController@get_dashboard');

	Route::group(['prefix'=>'mailbox'],function(){
		Route::post('update_mailbox','MailBox\MailBoxController@update_mailbox');
		Route::post('read_msg','MailBox\MailBoxController@read_msg');
		Route::post('save_draft','MailBox\MailBoxController@save_draft');
		Route::post('send_mail','MailBox\MailBoxController@send_mail');
	});
});


//Admin Route
Route::group(['prefix' => 'admin','middleware' => 'authrole_ad'], function () {
	Route::get('permission_denied', 'Admin\ProfileController@permission_denied' );

	Route::get('dashboard', 'Admin\ProfileController@get_ad_dashboard' );
	Route::post('dashboard', 'Admin\ProfileController@edit_info' );
	Route::post('dashboard/changepassword', 'Admin\ProfileController@changepassword' );


	Route::get('mailbox', 'MailBox\MailBoxController@get_mailbox');

	Route::get('position', 'Admin\PositionController@get_view');
	Route::post('position', 'Admin\PositionController@change_name');

	Route::group(['prefix'=>'manage-user', 'namespace' => 'Admin\UserManage'], function(){
		Route::get ('admin', 'AdminManageController@get_ad');
		Route::post('admin', 'AdminManageController@store_ad');
		Route::get ('admin/edit/{id}',  'AdminManageController@get_edit_form');
		Route::post ('admin/edit', 'AdminManageController@edit_ad');
		Route::get ('admin/edit/{id}/reset_password',  'AdminManageController@reset_password');

		Route::get ('teacher', 'TeacherManageController@get_view');
		Route::post('teacher', 'TeacherManageController@store_te');
		Route::post('teacher/search', 'TeacherManageController@search_te');
		Route::get ('teacher/edit/{id}', 'TeacherManageController@get_edit_form');
		Route::post ('teacher/edit', 'TeacherManageController@edit_te');
		Route::get ('teacher/edit/{id}/reset_password',  'TeacherManageController@reset_password');

		Route::get ('student', 'StudentManageController@get_stu');
		Route::post('student', 'StudentManageController@store_stu');
		Route::post('student/show', 'StudentManageController@show');
		Route::get ('student/edit/{id}', 'StudentManageController@get_edit_form');
		Route::post ('student/edit', 'StudentManageController@edit_stu');
		Route::get ('student/edit/{id}/reset_password',  'StudentManageController@reset_password');

		Route::get ('parent', 'ParentManageController@get_pa');
		Route::get ('parent/from_child/{id}', 'ParentManageController@get_pa_from_child');
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

	Route::get('editsubject/{id}', 'Admin\EditsubjectController@get_view');
	Route::post('editsubject', 'Admin\EditsubjectController@update');
	Route::post('editsubject/add_type', 'Admin\EditsubjectController@add_type');
	Route::post('editsubject/edit_type', 'Admin\EditsubjectController@edit_type');
	Route::post('editsubject/delete_type', 'Admin\EditsubjectController@delete_type');

	//Manage Schedule
	Route::get('schedule', 'Admin\ScheduleController@index');
	Route::post('schedule/getschedule', 'Admin\ScheduleController@getschedule');
	Route::post('schedule', 'Admin\ScheduleController@store');

	//Manage Transcript
	Route::get('transcript', 'Admin\TranscriptController@index');
	Route::post('transcript/getstudent', 'Admin\TranscriptController@getstudent');
	Route::post('transcript/gettranscript', 'Admin\TranscriptController@gettranscript');
	Route::get('transcript/general', 'Admin\TranscriptController@general_view');
	Route::post('transcript/general/updateclassname', 'Admin\TranscriptController@updateclassname');
	Route::post('transcript/general/set_time', 'Admin\TranscriptController@set_time');

});

//Teacher Route
Route::group(['prefix' => 'teacher','middleware' => 'authrole_te'], function () {
	Route::get('dashboard', 'Teacher\ProfileController@get_te_dashboard' );
	Route::post('dashboard', 'Teacher\ProfileController@edit_info' );
	Route::post('dashboard/changepassword', 'Teacher\ProfileController@changepassword');
	Route::get('permission_denied', 'Teacher\ProfileController@permission_denied' );

	//Mailbox
	Route::get('mailbox', 'MailBox\MailBoxController@get_mailbox');

	//transcript
	Route::get('transcript', 'Teacher\Transcript\TranscriptController@view');
	Route::get('transcript/{grade}', 'Teacher\Transcript\TranscriptController@sort');
	Route::get('transcript/download/{class_id}', 'Teacher\Transcript\TranscriptController@download');
	Route::post('transcript/import_file', 'Teacher\Transcript\TranscriptController@import_file');
	Route::post('transcript/save_transcript','Teacher\Transcript\TranscriptController@save_transcript' );
});

// Route::get('/bridge', function() {
//     $pusher = App::make('pusher');

//     $pusher->trigger( 'my_channel',
//                       'my-event', 
//                       array('text' => 'Preparing the Pusher Laracon.eu workshop!', 'messages' => "my fucking message"));

//     return view('welcome');
// });

