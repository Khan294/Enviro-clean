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

Auth::routes();
Route::get('/', function () {return view('login');});
Route::get('/dashboard', function () {return view('dashboard');});
Route::get('/users', function () {return view('userCRUD');});
Route::get('/chat', function () {return view('chat');});
Route::get('/schedule', function () {return view('schedule');});
Route::get('/region', function () {return view('regions');});
Route::get('/site', function () {return view('sites');});
Route::get('/fence', function () {return view('fence');});

//==============================================================================
use Illuminate\Http\Request;
Route::get('/token', function (Request $request) {
	if($request->wantsJson()){
		return response()->json([
		    'pass' => csrf_token()
		]);
	}
	return '<b> Not for web interface. </b> '. ($request->isJson()? '(Set proper content type)': '(Content okay)');
});