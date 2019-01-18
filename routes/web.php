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
	Route::get('/upload/bill', 'HomeController@uploadBill');
	Route::get('/upload/unbill', 'HomeController@uploadUnbill');	
	Route::get('/upload/dosier', 'HomeController@uploadDosier');
	Route::get('/upload/ukur-voice', 'HomeController@uploadUkurVoice');
	Route::get('/upload/gpon', 'HomeController@uploadGpon');

	Route::post('/upload-bill', 'UploadController@uploadBill')->name('upload.bill');
	Route::post('/upload-unbill', 'UploadController@uploadUnbill')->name('upload.unbill');
	Route::post('/upload-dosier', 'UploadController@uploadDosier')->name('upload.dosier');
	Route::post('/upload-ukur', 'UploadController@uploadUkurVoice')->name('upload.ukur.voice');
	Route::post('/upload-gpon', 'UploadController@uploadGpon')->name('upload.gpon');
	
	Route::get('/test', 'DownloadController@test');
	Route::get('/test2', 'DownloadController@test2');
	Route::post('/test3', 'DownloadController@test3')->name('test3');
});
Auth::routes();