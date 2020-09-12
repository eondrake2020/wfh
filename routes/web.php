<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','LoginController@index');
Route::post('/login','LoginController@store')->name('pasok');
Route::get('/logout','LoginController@logout')->name('gawas');

Route::get('/employee-login','DashboardController@login');
Route::get('/employee-logout','DashboardController@logout');

Route::get('/dashboard','DashboardController@index')->name('dashboard');
Route::get('/dashboard/events','DashboardController@show_events');
Route::get('/dashboard/edit-profile/{id}','DashboardController@edit_profile');
Route::get('/dashboard/attend-event/{id}','DashboardController@attend_event');
Route::get('/dashboard/view-task/{id}','DashboardController@view_task');
Route::get('/dashboard/view-task-replies/{id}','DashboardController@view_task_replies');
Route::get('/dashboard/my-schedule/{id}','DashboardController@view_schedule');
Route::get('/dashboard/view-dtr-request/{id}','DashboardController@view_dtr_requests');
Route::get('/dashboard/dtr-request/{id}','DashboardController@dtr_request');
Route::get('/dashboard/update-dtr-request/{id}','DashboardController@edit_dtr_request');
Route::get('/dashboard/view-violations/{id}','DashboardController@view_violations');

Route::post('/dashboard/view-task/{id}','DashboardController@post_task');
Route::post('/dashboard/view-task-replies/{id}','DashboardController@post_task_replies');
Route::post('/dashboard/my-schedule/{id}','DashboardController@post_schedule');
Route::patch('/dashboard/edit-profile/{id}','DashboardController@update_profile');
Route::post('/dashboard/dtr-request/{id}','DashboardController@post_dtr_request');
Route::post('/dashboard/update-dtr-request/{id}','DashboardController@update_dtr_request');
Route::patch('/dashboard/view-violations/{id}','DashboardController@update_violation');

Route::get('/dashboard/task-reply/{task_id}/{employee_id}','DashboardController@view_reply');
Route::post('/dashboard/task-reply/{task_id}/{employee_id}','DashboardController@post_reply');



Route::get('/change-password/{id}','ChangepasswordController@change_password');
Route::post('/change-password/{id}','ChangepasswordController@post_change_password');

Route::group(['middleware'=>'IsAdmin'], function(){
	Route::resource('/campuses','CampusController');
	Route::resource('/corrective-levels','CorrectivelevelController');

	Route::resource('/employees','EmployeeController');
	Route::get('/employees/set-admin/{id}','EmployeeController@setAdmin');
	Route::get('/employees/reset-password/{id}','EmployeeController@reset');
	
	Route::post('/employees/import','EmployeeController@import')->name('student-import');

	Route::resource('/employee-correctives','EmployeecorrectiveController');
	Route::get('/employee-correctives/view-details/{id}','EmployeecorrectiveController@view_details');
	Route::get('/employee-correctives/delete-entry/{id}','EmployeecorrectiveController@delete');

	Route::patch('/employee-correctives/view-details/{id}','EmployeecorrectiveController@update_details');

	Route::resource('/employee-groups','GroupController');
	Route::get('/employee-groups/delete/{id}','GroupController@delete');
	Route::get('/employee-groups/delete-member/{id}','GroupController@delete_member');

	Route::resource('/employee-logins','DtrController');

	Route::resource('/events','EventController');
	Route::get('/events/view-event-dates/{id}','EventController@view_event_list');
	Route::get('/events/print-attendance/{id}','EventController@print');
	Route::get('/events/delete-event/{id}','EventController@delete');

	Route::get('/reports/view-attendance-report','ReportController@view_attendance_report');
	Route::post('/reports/view-attendance-report','ReportController@print_attendance_report');

	Route::get('/getCombo','TaskController@getCombo');
	Route::resource('tasks','TaskController');
	Route::get('/tasks/delete/{id}','TaskController@delete');
	Route::get('/tasks/delete-member/{id}','TaskController@delete_member');
	Route::get('/tasks/close-task/{id}','TaskController@close_task');
});