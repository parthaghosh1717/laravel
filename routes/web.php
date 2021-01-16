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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'user','namespace'=>'user'],function(){ 
	Route::get('/token/{token}','verificationController@verify')->name('user_verification');
	Route::get('/dashboard','UserController@dashboard')->name('user_dashboard');
	Route::get('/User_profile','UserController@User_profile')->name('User_profile');
	Route::post('/User_profile/Update','UserController@User_profile_Update')->name('User_profile_Update');	 
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Login
Route::get('login', 'Auth\LoginController@showUserLoginForm')->name('login'); 
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('user-email-check', 'Auth\RegisterController@userEmailCheck')->name('user.email.check');

Route::group(['namespace' => 'Modules','middleware' => 'auth'], function() {

	Route::group(['namespace' => 'Student'], function() {
		// Student Dashboard Routes.
		Route::get('student-dashboard', 'DashboardController@dashboard')->name('student.dashboard');
		Route::post('store-project', 'ProjectController@storeProject')->name('store_project_details');
		Route::get('update-project', 'ProjectController@updateProject')->name('get.project');
		Route::post('delete-project', 'ProjectController@deleteProject')->name('delete.project');

	});

	Route::group(['namespace' => 'Teacher'], function() {
		// Student Dashboard Routes.
		Route::get('Teacher-dashboard', 'TeacherDashboardController@dashboard')->name('teacher.dashboard');
	});

});