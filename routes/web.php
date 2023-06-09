<?php

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

Route::view('/', 'auth.login');

Auth::routes();
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/dashboard', 'Dashboard@index')->name('dashboard');

    // ====================================Designation===================================
    Route::get('/designation', 'DesignationController@index')->name('designation');
    Route::post('/addDesignation', 'DesignationController@addDesignation')->name('addDesignation');
    // Route::get('/editTest/{id}', 'TestController@editTest')->name('editTest');
    // Route::post('/updateTest', 'TestController@updateTest')->name('updateTest');
    Route::get('/deleteDesignation/{id}', 'DesignationController@deleteDesignation')->name('deleteDesignation');
    // ====================================Designation===================================
    
    //====================================Shift===================================
    Route::get('/shift', 'ShiftController@index')->name('shift');
    Route::post('/addShift', 'ShiftController@addShift')->name('addShift');
    Route::get('/deleteShift/{id}', 'ShiftController@deleteShift')->name('deleteShift');
    //====================================Shift===================================

    // ====================================Employee===================================
    Route::get('/employee', 'EmployeeController@index')->name('employee');
    Route::post('/addEmployee', 'EmployeeController@addEmployee')->name('addEmployee');
    // Route::get('/editEmployee/{id}', 'EmployeeController@editEmployee')->name('editEmployee');
    // Route::post('/updateEmployee', 'EmployeeController@updateEmployee')->name('updateEmployee');
    Route::get('/deleteEmployee/{id}', 'EmployeeController@deleteEmployee')->name('deleteEmployee');
    // ====================================Employee===================================


    // ====================================Attendance===================================
    Route::get('/attendance', 'AttendanceController@index')->name('attendance');
    Route::get('/checkInOut/{id}/{check}/{shiftsId}', 'AttendanceController@checkInOut')->name('checkInOut');
    Route::get('/breakFast/{id}/{breakfast}', 'AttendanceController@breakFast')->name('breakFast');
    Route::get('/lunch/{id}/{lunch}', 'AttendanceController@lunch')->name('lunch');
    // ====================================Attendance===================================


    // ====================================Report===================================
    Route::get('/report', 'ReportController@index')->name('report');
    // ====================================Report===================================

    

    // ====================================AJAX REQUESTS route start===================================
    Route::get('/ajax/all_employees','EmployeeController@all_employees')->name('ajax.all_employees');
    // Route::get('/ajax/all_group/{c_id}','ProductController@all_group')->name('ajax.all_group');
    // Route::get('/ajax/company_wise_group/{c_id}','ProductController@company_wise_group')->name('ajax.company_wise_group');

    // ====================================AJAX REQUESTS route end======================================

});
