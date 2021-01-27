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

Route::redirect('/','/login');

Auth::routes(['register'=>false,'reset' => false]);

Route::group(['middleware' => 'customauth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    route::post('search/student','homecontroller@searchstudent')->name('student.search');
    Route::middleware('can:create-hr')->group(function(){
        // HR Routes
        Route::resource('hr', 'HrController');
        // Route::post('hr/search', 'hrcontroller@searchhr')->name('hr.search');
    });

    // Notes routes
    Route::resource('notes', 'NotesController');

    // Policy Routes
    route::post('updatepolicy/{id}','homecontroller@updatepolicy')->name('update.policy');
    route::post('savepolicy','homecontroller@store')->name('save.policy');


    Route::post('updatestudent','RecrutingController@updatestudent')->name('updatestudent');

    // Recruting Routes
    Route::resource('recrut','RecrutingController')->only(['index','store','show','destroy']);
    route::post('stateupdate','recrutingcontroller@updateorder')->name('recrut.updatestate');

    // Job Routes
    Route::resource('job', 'JobsController');
    // Search Job Routes
    Route::post('job/search', 'jobscontroller@searchjob')->name('job.search');


    // Profile Routes
    route::get('profile','usercontroller@viewprofile')->name('profile.show');
    route::post('profileupdate','usercontroller@updateprofile')->name('profile.update');




    // Fetch technology and State routes
    Route::get('fetchtechnology','HomeController@technology')->name('technology');
    Route::get('fetchstate','HomeController@state')->name('state');

    // Search Student Dashboard Page
    Route::post('studentsearch', 'HomeController@student')->name('studentsearch');

    // Search HR Page
    Route::post('hrsearch','HrController@fetch_hr')->name('hrsearch');

    // Search Job Page
    Route::post('jobsearch','JobsController@fetch_job')->name('jobsearch');

    // Search Note Page
    Route::post('notesearch','NotesController@fetch_note')->name('notesearch');

    // Multiple Job,HR,Notes,Student Delete
    Route::delete('delete-multiple-jobs','JobsController@deleteMultipleJobs')->name('deletemultiplejobs');
    Route::delete('delete-multiple-notes','NotesController@deleteMultipleNotes')->name('deletemultiplenotes');
    Route::delete('delete-multiple-hrs','HrController@deleteMultipleHrs')->name('deletemultiplehrs');
    Route::delete('delete-multiple-students','HomeController@deleteMultipleStudents')->name('deletemultiplestudents');

    // User Change Password
    Route::get('password','UserController@password')->name('password');
    Route::post('password','UserController@update')->name('UpdatePassword');




    // faltu
    Route::post('updatehr','HrController@updatehr')->name('updatehr');
    Route::post('updatejob','JobsController@updatejob')->name('updatejob');
    Route::post('updatenote','NotesController@updatenote')->name('updatenote');


    Route::get('ajaxfetch','HomeController@fetch')->name('ajaxfetch');
    Route::post('ajaxupdate','HomeController@update')->name('ajaxupdate');

});