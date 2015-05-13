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

//login route
Route::get('/', 'LoginController@index');
Route::get('/mytest', 'LoginController@test');
Route::get('/login', 'LoginController@index');
Route::get('/excel', 'LoginController@excel');
Route::get('/signout', 'LoginController@signout');
Route::post('/login', 'LoginController@login');


Route::get('/home', 'HomeController@index');

//absent route
Route::post('/absent', 'AbsentController@add_absent');
Route::post('/edit_absent', 'AbsentController@edit_absent');
Route::post('/add_absent_manual', 'AbsentController@add_absent_manual');
Route::post('/rekap_absent', 'AbsentController@rekap_absent');
Route::get('/absent', 'AbsentController@index');
Route::get('/rekap_absent', 'AbsentController@rekap_absent');
Route::get('/export_xls_absent', 'AbsentController@export_xls_absent');
Route::get('/absent/{id}', ['uses' =>'AbsentController@update_absent', 'as'=>'update_absent']);
Route::get('/data_absent',['as' => 'data_absent','uses' => 'AbsentController@data_absent']);
Route::get('/get_edit_absent/{id}',['as' => 'get_edit_absent','uses' => 'AbsentController@get_edit_absent']);
Route::get('/delete_absent/{id}',['as' => 'delete_absent','uses' => 'AbsentController@delete_absent']);

//schedule route
Route::get('/schedule','ScheduleController@index');
Route::get('/delete_schedule/{id}',['as' => 'delete_schedule','uses' => 'ScheduleController@delete_schedule']);
Route::get('/get_detail_schedule/{id}', ['uses' =>'ScheduleController@get_detail_schedule', 'as'=>'get_detail_schedule']);
Route::get('/get_detail_member_schedule/{Jadwal_ID}', ['uses' =>'ScheduleController@get_detail_member_schedule', 'as'=>'get_detail_member_schedule']);
Route::get('/get_edit_schedule/{id}', ['uses' =>'ScheduleController@get_edit_schedule', 'as'=>'get_edit_schedule']);
Route::post('/schedule','ScheduleController@add_schedule');
Route::post('/edit_schedule','ScheduleController@edit_schedule');

//file route
Route::get('/file_pdf','FileController@pdf_list_view');
Route::get('/file_pdf/{id}', ['uses' =>'FileController@view_detail_pdf', 'as'=>'view_pdf']);
Route::get('/file_images','FileController@image_list_view');

//Laporan Trainning route
Route::get('/trainning','TrainningController@index');
Route::get('/trainning_report/{Jadwal_ID}',['uses' =>'TrainningController@add_report_trainning_form', 'as'=>'add_report_trainning_form']);
Route::get('/update_trainning_report/{Report_trainning_ID}',['uses' =>'TrainningController@update_report_trainning_form', 'as'=>'update_report_trainning_form']);
Route::get('/detail_trainning_report/{Report_trainning_ID}',['uses' =>'TrainningController@detail_report_trainning_form', 'as'=>'detail_report_trainning_form']);
Route::get('/delete_trainning_report/{Report_trainning_ID}',['uses' =>'TrainningController@delete_report_trainning', 'as'=>'delete_report_trainning']);
Route::get('/approve_trainning_report/{Report_trainning_ID}',['uses' =>'TrainningController@approve_report_trainning', 'as'=>'approve_report_trainning']);
Route::get('/get_detail_member_report_trainning/{Report_trainning_ID}', ['uses' =>'TrainningController@get_detail_member_report_trainning', 'as'=>'get_detail_member_report_trainning']);
Route::post('/add_trainning_report','TrainningController@add_trainning_report');
Route::post('/update_trainning_report','TrainningController@update_trainning_report');
Route::post('/upload_image_trainning_report','TrainningController@upload_image_trainning_report');


//Laporan Instalasi route
Route::get('/instalation','InstalationController@index');
Route::get('/instalation_report/{Jadwal_ID}',['uses' =>'InstalationController@add_report_instalation_form', 'as'=>'add_report_instalation_form']);
Route::get('/update_instalation_report/{Report_instalation_ID}',['uses' =>'InstalationController@update_report_instalation_form', 'as'=>'update_report_instalation_form']);
Route::get('/detail_instalation_report/{Report_instalation_ID}',['uses' =>'InstalationController@detail_report_instalation_form', 'as'=>'detail_report_instalation_form']);
Route::get('/delete_instalation_report/{Report_instalation_ID}',['uses' =>'InstalationController@delete_report_instalation', 'as'=>'delete_report_instalation']);
Route::get('/approve_instalation_report/{Report_instalation_ID}',['uses' =>'InstalationController@approve_report_instalation', 'as'=>'approve_report_instalation']);
Route::get('/get_detail_member_report_instalation/{Report_instalation_ID}', ['uses' =>'InstalationController@get_detail_member_report_instalation', 'as'=>'get_detail_member_report_instalation']);
Route::post('/add_instalation_report','InstalationController@add_instalation_report');
Route::post('/update_instalation_report','InstalationController@update_instalation_report');
Route::post('/upload_image_instalation_report','InstalationController@upload_image_instalation_report');

//Laporan Troubleshoot route
Route::get('/troubleshoot','TroubleshootController@index');
Route::get('/troubleshoot_report/{Jadwal_ID}',['uses' =>'TroubleshootController@add_report_troubleshoot_form', 'as'=>'add_report_troubleshoot_form']);
Route::get('/update_troubleshoot_report/{Report_troubleshoot_ID}',['uses' =>'TroubleshootController@update_report_troubleshoot_form', 'as'=>'update_report_troubleshoot_form']);
Route::get('/detail_troubleshoot_report/{Report_troubleshoot_ID}',['uses' =>'TroubleshootController@detail_report_troubleshoot_form', 'as'=>'detail_report_troubleshoot_form']);
Route::get('/delete_troubleshoot_report/{Report_troubleshoot_ID}',['uses' =>'TroubleshootController@delete_report_troubleshoot', 'as'=>'delete_report_troubleshoot']);
Route::get('/approve_troubleshoot_report/{Report_troubleshoot_ID}',['uses' =>'TroubleshootController@approve_report_troubleshoot', 'as'=>'approve_report_troubleshoot']);
Route::get('/get_detail_member_report_troubleshoot/{Report_troubleshoot_ID}', ['uses' =>'TroubleshootController@get_detail_member_report_troubleshoot', 'as'=>'get_detail_member_report_troubleshoot']);
Route::post('/add_troubleshoot_report','TroubleshootController@add_troubleshoot_report');
Route::post('/update_troubleshoot_report','TroubleshootController@update_troubleshoot_report');
Route::post('/upload_image_troubleshoot_report','TroubleshootController@upload_image_troubleshoot_report');


//Laporan Maintenance route
Route::get('/maintenance','MaintenanceController@index');
Route::get('/maintenance_report/{Jadwal_ID}',['uses' =>'MaintenanceController@add_report_maintenance_form', 'as'=>'add_report_maintenance_form']);
Route::get('/update_maintenance_report/{Report_maintenance_ID}',['uses' =>'MaintenanceController@update_report_maintenance_form', 'as'=>'update_report_maintenance_form']);
Route::get('/detail_maintenance_report/{Report_maintenance_ID}',['uses' =>'MaintenanceController@detail_report_maintenance_form', 'as'=>'detail_report_maintenance_form']);
Route::get('/delete_maintenance_report/{Report_maintenance_ID}',['uses' =>'MaintenanceController@delete_report_maintenance', 'as'=>'delete_report_maintenance']);
Route::get('/approve_maintenance_report/{Report_maintenance_ID}',['uses' =>'MaintenanceController@approve_report_maintenance', 'as'=>'approve_report_maintenance']);
Route::get('/get_detail_member_report_maintenance/{Report_maintenance_ID}', ['uses' =>'MaintenanceController@get_detail_member_report_maintenance', 'as'=>'get_detail_member_report_maintenance']);
Route::post('/add_maintenance_report','MaintenanceController@add_maintenance_report');
Route::post('/update_maintenance_report','MaintenanceController@update_maintenance_report');
Route::post('/upload_image_maintenance_report','MaintenanceController@upload_image_maintenance_report');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);