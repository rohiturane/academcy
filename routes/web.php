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

Route::get('/', function () {
  if(Auth::user()) {
    if(Auth::user()->role == 1) {
        return redirect('/home');
    } else {
        return redirect('/student/dashboard');
    }
  } else {
    return redirect('/login');
  }
})->name('main');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);

Route::group(['middleware' => 'auth'], function() {

  Route::get('/change/password','HomeController@changePassword')->name('changePassword');
  Route::post('/changePassword','HomeController@updatePassword')->name('updatePassword');

  //Student dashboard & permission
  Route::group(['middleware'=>'student'], function() {

    Route::get('/student/dashboard','StudentController@dashboard')->name('student.dashboard');
    Route::get('/allcourse','CourseController@allCourse')->name('course.alllist');
    Route::get('/course/{uuid}/enrolled','CourseController@courseEnrolled')->name('course.enrolled');
    Route::get('/course/{uuid}/video/{id}','StudentController@videoSeen')->name('student.videoseen');
  });

  //Admin dashboard & permission
  Route::group(['middleware'=>'admin'], function() {

      Route::get('/home', 'HomeController@index')->name('home');

      //Student
      Route::get('/student', 'StudentController@index')->name('student.index');
      Route::get('/student/create', 'StudentController@create')->name('student.create');
      Route::post('/student/store','StudentController@store')->name('student.store');
      Route::get('/student/{uuid}/edit','StudentController@edit')->name('student.edit');
      Route::put('/student/{uuid}/update','StudentController@update')->name('student.update');
      Route::delete('/student/{uuid}/delete','StudentController@destroy')->name('student.delete');

      //Course
      Route::get('/course', 'CourseController@index')->name('course.index');
      Route::get('/course/create','CourseController@create')->name('course.create');
      Route::post('/course/store','CourseController@store')->name('course.store');
      Route::get('/course/{uuid}/edit','CourseController@edit')->name('course.edit');
      Route::put('/course/{uuid}/update','CourseController@update')->name('course.update');
      Route::delete('/course/{uuid}/delete','CourseController@destroy')->name('course.delete');

      //playlist
      Route::get('/course/{uuid}/playlist','CourseController@playlist')->name('course.playlist');
      Route::delete('/course/{uuid}/{id}/delete','CourseController@playdelete')->name('courseplay.delete');
      Route::post('/course/{uuid}/store','CourseController@playstore')->name('courseplay.store');
      Route::get('/course/{uuid}/videocreate','CourseController@playcreate')->name('courseplay.create');
      Route::get('/course/{uuid}/{id}/videoedit','CourseController@playedit')->name('courseplay.edit');
      Route::put('/course/{uuid}/{id}/update','CourseController@playupdate')->name('courseplay.update');

      //Student Logged in Devices
      Route::get('/student/{uuid}/devices','StudentController@alldevices')->name('student.devices');
      Route::get('/student/{uuid}/resetdevice','StudentController@resetDevice')->name('student.deviceReset');
  });
});