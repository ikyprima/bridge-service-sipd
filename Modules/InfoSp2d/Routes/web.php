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

Route::prefix('infosp2d')->group(function() {
    Route::get('/', 'InfoSp2dController@index');
    Route::get('/import-sp2d','InfoSp2dController@importSp2dVerifikasi');

    //public
    Route::get('/sp2d-verifikasi','InfoSp2dPublicController@index')->name('info-sp2d-verifikasi');
    
});


