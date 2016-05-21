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

// Android Api
// Login
Route::post('api/login','Api\MobileAuthController@login');
Route::group(['prefix' => 'api', 'middleware' => 'apiguard'],function(){
	Route::get('user_info', 'Api\MobileAuthController@get_user_info');
	Route::get('get_schedule','Api\MobileScheduleController@get_schedule');

	Route::group(['prefix' => 'mailbox'], function(){
		Route::get('get_inbox', 'Api\MailboxController@get_inbox');
		Route::post('get_mail_on_login', 'Api\MailboxController@get_mail_on_login');
	});

	Route::group(['prefix' => 'teacher'],function(){

	});

	Route::group(['prefix' => 'parent'],function(){
		Route::post('get_schedule', 'Api\MobileScheduleController@parent_get_schedule');
	});


	Route::group(['prefix' => 'post'], function(){
		Route::post('get_notice_detail', 'Api\NoticeboardController@get_notice_detail');
		Route::post('get_transcript', 'Api\MobileTranscriptController@get_transcript');

		Route::group(['prefix' => 'mailbox'], function(){
			// Route::post('get_mail_on_login', 'Api\MailboxController@get_mail_on_login');
		});

		Route::group(['prefix' => 'student'],function(){
			Route::post('get_noticeboard', 'Api\NoticeBoardController@get_stu_noticeboard');
		});
		Route::group(['prefix' => 'parent'],function(){
			Route::post('get_schedule', 'Api\MobileScheduleController@parent_get_schedule');
			Route::post('get_noticeboard', 'Api\NoticeBoardController@get_pa_noticeboard');
		});
	});
});
//***************************************************************//
// Authentication routes...
Route::get('/', 'Auth\MyAuthController@getview');
Route::post('/get_info', 'Auth\MyAuthController@get_info');
Route::get('/test', 'Test\TestController@test');
Route::post('/auth/login', 'Auth\MyAuthController@authenticate');
Route::get('/auth/logout', 'Auth\MyAuthController@logout');

// Error Route
Route::get('/permission_denied', 'Auth\MyAuthController@permission_denied');

//common route
Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard','Auth\MyAuthController@get_dashboard');

	Route::group(['prefix'=>'mailbox'],function(){
		Route::post('update_mailbox','Mailbox\MailBoxController@update_mailbox');
		Route::post('read_msg','Mailbox\MailBoxController@read_msg');
		Route::post('save_draft','Mailbox\MailBoxController@save_draft');
		Route::post('send_mail','Mailbox\MailBoxController@my_send_mail');
		Route::post('delete_mail','Mailbox\MailBoxController@delete_mail');
		Route::post('draft_edit', 'Mailbox\MailBoxController@draft_edit');
		Route::post('draft_send', 'Mailbox\MailBoxController@draft_send');
	});
});

//Admin Route
Route::group(['prefix' => 'admin','middleware' => 'authrole_ad'], function () {
	Route::get('permission_denied', 'Admin\ProfileController@permission_denied' );

	Route::get('dashboard', 'Admin\ProfileController@get_ad_dashboard' );
	Route::post('dashboard', 'Admin\ProfileController@edit_info' );
	Route::post('dashboard/changepassword', 'Admin\ProfileController@changepassword' );

	Route::get('mailbox', 'Mailbox\MailBoxController@get_mailbox');

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
		Route::post ('teacher/change-status', 'TeacherManageController@change_status');
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
	Route::post('editsubject/disable_scoretype', 'Admin\EditsubjectController@disable_scoretype');

	//Manage Schedule
	Route::get('schedule', 'Admin\ScheduleController@index');
	Route::post('schedule/getschedule', 'Admin\ScheduleController@getschedule');
	Route::post('schedule', 'Admin\ScheduleController@store');

	//Manage Transcript
	Route::get('transcript/general', 'Admin\TranscriptController@general_view');
	Route::post('transcript/general/updateclassname', 'Admin\TranscriptController@updateclassname');
	Route::post('transcript/general/set_time', 'Admin\TranscriptController@set_time');

	//Route::group(['prefix' => 'schedule','middleware' => 'authrole_te'], function () {
	Route::get('/menuschedule', 'ScheduleControler@menu');
	//Route::post('/menuschedule/check', 'ScheduleControler@menucheck');
	Route::get('/chinhsuaphancong', 'ScheduleControler@chinhsuaphancong');
	Route::get('/phancong','ScheduleControler@phancong_index');
	Route::post('/phancong/createnew','ScheduleControler@createnewphancong');
	Route::post('/phancong/edit', 'ScheduleControler@edit');	
	Route::post('/phancong/addnew', 'ScheduleControler@addnew');
	Route::post('/phancong/removeclass', 'ScheduleControler@removeclass');
	Route::post('/phancong/check', "ScheduleControler@checkredirection");

	Route::get('/tkbgv_index','ScheduleControler@tkbgv_index');
	Route::post('/tkbgv_index/createNewSchedule','ScheduleControler@getNewSchedule');
	Route::get('/tkblop_index', 'ScheduleControler@tkblop_index');
	
	Route::get('/tkbhientai', 'ScheduleControler@tkbhientai');
	Route::post('/tkbhientai/updatetkbgv', 'ScheduleControler@updatetkbgv');
	Route::get('/tkblopcu', 'ScheduleControler@tkblop_index');
	Route::post('/tkblopcu/updatetkbclass', 'ScheduleControler@updatetkbclass');
	
	Route::get('/tkbgvthaydoi_index', 'ScheduleControler@tkbgvthaydoi_index');
	Route::post('/tkbgvthaydoi_index/capnhat', 'ScheduleControler@tkbgvthaydoi_capnhat');
	Route::get('/phancongcacnam', 'ScheduleControler@phancongcacnam');
	Route::post('/bangphancongcu', 'ScheduleControler@bangphancongcu');

	Route::group(['prefix' => 'statistic', 'namespace' =>'Admin\Statistic'], function(){
		Route::get('numberofstudent' , 'NumberOfStudentController@get_view');
		Route::post('numberofstudent/get_data', 'NumberOfStudentController@get_data');
		Route::get('transcript' , 'TranscriptController@get_view');
		Route::post('transcript/get_data' , 'TranscriptController@get_data');
	});

});

//Teacher Route
Route::group(['prefix' => 'teacher','middleware' => 'authrole_te'], function () {
	Route::get('dashboard', 'Teacher\ProfileController@get_te_dashboard' );
	Route::post('dashboard', 'Teacher\ProfileController@edit_info' );
	Route::post('dashboard/upload_image', 'Teacher\ProfileController@upload_image' );
	Route::post('dashboard/changepassword', 'Teacher\ProfileController@changepassword');
	Route::get('permission_denied', 'Teacher\ProfileController@permission_denied' );

	//Mailbox
	Route::get('mailbox', 'Mailbox\MailBoxController@get_mailbox');

	//transcript manage
	Route::get('transcript', 'Teacher\Transcript\TranscriptController@view');
	Route::get('transcript/{grade}', 'Teacher\Transcript\TranscriptController@sort');
	Route::get('transcript/download/{class_id}', 'Teacher\Transcript\TranscriptController@download');
	Route::post('transcript/import_file', 'Teacher\Transcript\TranscriptController@import_file');
	Route::post('transcript/save_transcript','Teacher\Transcript\TranscriptController@save_transcript' );
	Route::post('transcript/get_transcript','Teacher\Transcript\TranscriptController@get_transcript' );
	Route::post('transcript/edit_transcript','Teacher\Transcript\TranscriptController@edit_transcript' );
	Route::post('transcript/view_transcript_get_class', 'Teacher\Transcript\TranscriptController@view_transcript_get_class');
	Route::post('transcript/view_transcript_get_score', 'Teacher\Transcript\TranscriptController@view_transcript_get_score');

	//class Manage
	Route::get('manage-class', 'Teacher\ManageclassController@get_view');
	Route::post('manage-class/update', 'Teacher\ManageclassController@update');
	Route::post('manage-class/set_conduct', 'Teacher\ManageclassController@set_conduct');
	Route::post('manage-class/add_note', 'Teacher\ManageclassController@add_note');
	//view transcript
	Route::get('view_transcript', 'Teacher\Transcript\TranscriptController@view_transcript');
	// Schedule
	Route::get('schedule', 'Teacher\ScheduleController@get_view');
	// Notice Board
	Route::get('noticeboard', 'Teacher\NoticeboardController@get_view');
	Route::post('noticeboard/add_notice', 'Teacher\NoticeboardController@add_notice');
	Route::post('noticeboard/read_notice', 'Teacher\NoticeboardController@read_notice');
	// Class List
	Route::get('student-list' , 'Teacher\StudentListController@get_view');
	Route::post('student-list/get_student_list' , 'Teacher\StudentListController@get_student_list');
	Route::post('student-list/get_enrolled_year' , 'Teacher\StudentListController@get_enrolled_year');

});

//Student Route
Route::group(['prefix' => 'student','middleware' => 'authrole_stu'], function () {
	Route::get('dashboard', 'Student\ProfileController@get_stu_dashboard' );
	Route::post('dashboard', 'Student\ProfileController@edit_info' );
	Route::post('dashboard/upload_image', 'Student\ProfileController@upload_image' );
	Route::post('dashboard/changepassword', 'Student\ProfileController@changepassword');
	Route::get('permission_denied', 'Student\ProfileController@permission_denied' );

	//Mailbox
	Route::get('mailbox', 'Mailbox\MailBoxController@get_mailbox');

	//Transcript
	Route::get('transcript', 'Student\TranscriptController@get_view');
	Route::post('transcript/select_class', 'Student\TranscriptController@select_class');
	Route::post('transcript/select_subject', 'Student\TranscriptController@select_subject');
	
	//Schedules
	Route::get('schedule', 'Student\ScheduleController@get_view');
	//Notice Board
	Route::get('notice_board', 'Student\NoticeboardController@get_view');
	Route::post('notice_board/read_notice', 'Student\NoticeboardController@read_notice');

	Route::get('teacher_list', 'Student\TeacherListController@get_view');
	Route::post('teacher_list/select_teacher', 'Student\TeacherListController@select_teacher');
});

//Parent Route
Route::group(['prefix' => 'parents','middleware' => 'authrole_pa'], function () {
	Route::get('dashboard', 'Parents\ProfileController@get_pa_dashboard' );
	Route::post('dashboard', 'Parents\ProfileController@edit_info' );
	Route::post('dashboard/changepassword', 'Parents\ProfileController@changepassword');
	Route::get('permission_denied', 'Parents\ProfileController@permission_denied' );

	//Teacher List
	Route::get('teacher_list', 'Parents\TeacherListController@get_view');
	Route::get('teacher_list/{student_id}', 'Parents\TeacherListController@get_teacher_list');
	Route::post('teacher_list/select_teacher', 'Parents\TeacherListController@select_teacher');
	//Mailbox
	Route::get('mailbox', 'Mailbox\MailBoxController@get_mailbox');

	//Schedules
	Route::get('schedule', 'Parents\ScheduleController@get_view');
	Route::get('schedule/student_schedule/{student_id}', 'Parents\ScheduleController@show_student_schedule');

	//Transcript
	Route::get('transcript', 'Parents\TranscriptController@get_view');
	Route::get('transcript/student_transcript/{student_id}', 'Parents\TranscriptController@show_student_transcript');
	Route::post('transcript/select_class', 'Parents\TranscriptController@select_class');
	Route::post('transcript/select_subject', 'Parents\TranscriptController@select_subject');

	//Notice Board
	Route::get('notice_board', 'Parents\NoticeboardController@get_view');
	Route::get('notice_board/student_noticeboard/{student_id}', 'Parents\NoticeboardController@get_student_noticeboard');
	Route::post('notice_board/read_notice', 'Parents\NoticeboardController@read_notice');
});

