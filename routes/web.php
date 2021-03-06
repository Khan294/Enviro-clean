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


// Authentication Routes...
//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/token', 'Auth\LoginController@getToken');
Route::get('/', function () {return view('login');});

Route::resource('shift', 'ShiftController');
Route::post('shiftFilter', 'ShiftController@shiftFilter');
Route::resource('user', 'UserController');
Route::get('userbyregion/{id}', 'UserController@userbyregion');

Route::get('roledUser/{role}', 'UserController@getRole');

Route::resource('region', 'RegionController');
Route::resource('site', 'SiteController');
Route::get('sitebyregion/{id}', 'SiteController@sitebyregion');

Route::resource('fence', 'FenceController');
Route::resource('violation', 'ViolationController');
Route::get('violationbysite/{id}', 'ViolationController@violationbysite');

Route::resource('infraction', 'InfractionController');
Route::resource('siteclock', 'SiteClockController');
Route::resource('fenceclock', 'FenceClockController');

Route::get('dashboard', 'DashboardController@index');
Route::get('downloadCsv', 'ViolationController@downloadCsv');
Route::get('downloadJson', 'ViolationController@downloadJson');

Route::resource('chat', 'ChatController');
Route::get('/chatPop/{header}', 'ChatController@chatPop');
Route::get('/chatWalkie', 'ChatController@chatWalkie');
Route::get('/chatWalkiePop/{header}', 'ChatController@chatWalkiePop');
Route::get('/chatOne', 'ChatController@chatOne');
Route::get('/chatOnePop/{header}', 'ChatController@chatOnePop');

Route::prefix('photo')->group(function () {
  Route::get('/', "PhotoController@index");
});