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
	Route::get('/', 'HomeController@index')->name('index');
	Route::get('/unbill', 'HomeController@unbill');
	Route::get('/data/full/{snd}/{bulan}', 'HomeController@getData');

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
	Route::get('/cek-data/{b}', 'HomeController@cekData')->name('cek.data');
	Route::get('/download/full/data/{bulan}', 'HomeController@fullData');
	Route::get('/download/full/data2/{bulan}', 'HomeController@fullData2');
	Route::get('/download/finance/data/{bulan}', 'HomeController@billData');
	Route::get('/download/finance/data2/{bulan}', 'HomeController@billData2');
	Route::post('/sync-data', 'HomeController@syncData')->name('sync.data');
	Route::get('/search', 'HomeController@cariData')->name('cari.data');
});
Auth::routes();