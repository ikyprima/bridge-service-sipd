<?php

use Illuminate\Http\Request;
use Modules\InfoSp2d\Http\Controllers\InfoSp2dController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/infosp2d', function (Request $request) {
    return $request->user();
});
Route::prefix('sp2d')->group(function() {
    Route::get('/list-sp2d-verifikasi',[InfoSp2dController::class, 'listSp2dVerifikasi']);
});
