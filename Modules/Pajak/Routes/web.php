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

Route::prefix('pajak')->group(function() {
    Route::get('/', 'PajakController@index')->name('pajak.index');
    Route::get('/excel-import','PajakController@excelImport');
    Route::post('/','PajakController@uploadExcel')->name('pajak.upload.excel');
    Route::post('/filter','PajakController@excelImport')->name('pajak.synch.excel');
    Route::get('/export-rekap','PajakController@exportExcelPajak')->name('pajak.export.rekap');
    
    Route::put('/{id}','PajakController@update')->name('pajak.update');
    Route::put('/ver/{id}','PajakController@updateVerifikasi')->name('pajak.verifikasi');

    Route::get('/export', 'PajakController@exportExcelPajak')->name('pajak.export');

    Route::put('/visible/{id}','PajakController@updateVisible')->name('pajak.visible.rekgaji');
    route::post('/get-list-rek-gaji', 'PajakController@listRekeningGaji')->name('pajak.list.rekening.gaji');

    
});
