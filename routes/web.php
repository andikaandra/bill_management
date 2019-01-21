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
	Route::get('/data/bill/{id}/{snd}/{bulan}/{tipe}', 'HomeController@getData');

	Route::get('/upload/bill', 'HomeController@uploadBill');
	Route::get('/upload/unbill', 'HomeController@uploadUnbill');	
	Route::get('/upload/dosier', 'HomeController@uploadDosier');
	Route::get('/upload/ukur-voice', 'HomeController@uploadUkurVoice');
	Route::get('/upload/gpon', 'HomeController@uploadGpon');

	Route::get('/download/bill', 'HomeController@downloadBill');
	Route::get('/download/unbill', 'HomeController@downloadUnbill');	
	Route::get('/download/dosier', 'HomeController@downloadDosier');
	Route::get('/download/ukur-voice', 'HomeController@downloadUkurVoice');
	Route::get('/download/gpon', 'HomeController@downloadGpon');

	Route::get('/download/bill/{bulan}/{tipe}', 'DownloadController@downloadBill');
	Route::get('/download/unbill/{bulan}/{tipe}', 'DownloadController@downloadUnbill');	
	Route::get('/download/dosier/{bulan}/{tipe}', 'DownloadController@downloadDosier');
	Route::get('/download/dosier-mod/{bulan}/{tipe}', 'DownloadController@downloadDosierMod');
	Route::get('/download/ukur-voice/{bulan}/{tipe}', 'DownloadController@downloadUkurVoice');
	Route::get('/download/gpon/{bulan}/{tipe}', 'DownloadController@downloadGpon');

	Route::post('/upload-bill', 'UploadController@uploadBill')->name('upload.bill');
	Route::post('/upload-unbill', 'UploadController@uploadUnbill')->name('upload.unbill');
	Route::post('/upload-dosier', 'UploadController@uploadDosier')->name('upload.dosier');
	Route::post('/upload-ukur', 'UploadController@uploadUkurVoice')->name('upload.ukur.voice');
	Route::post('/upload-gpon', 'UploadController@uploadGpon')->name('upload.gpon');

	Route::post('/test3', 'DownloadController@test3')->name('test3');
});
Auth::routes();