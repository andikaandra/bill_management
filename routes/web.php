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

// Route::get('/', function () {
//     return view('auth.login');
// });



Route::group(['middleware' => ['admin_only']], function(){
	Route::get('/', 'HomeController@index');
	Route::get('/unbill', 'HomeController@unbill');
	Route::get('/data/bill/{id}/{snd}/{bulan}', 'HomeController@getData');
	Route::get('/download', 'HomeController@download');
});
Auth::routes();

Route::get('/export', 'HomeController@export');
Route::get('/export-fast', 'HomeController@exportFast');

Route::get('/import', 'HomeController@import');
Route::get('/import-fast', 'HomeController@importFast');

Route::get('/test', 'HomeController@test');
// Route::get('/test', 'HomeController@test')->name('test');
