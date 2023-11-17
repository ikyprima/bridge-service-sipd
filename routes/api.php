<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sp2d;
use App\Http\Controllers\AklapController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data-skpd',[sp2d::class, 'dataSkpd']);
Route::post('/history-sp2d',[sp2d::class, 'getDataSp2dHistory']);
Route::get('/list-sp2d-verifikasi',[sp2d::class, 'getDataSp2dVerifikasi']);


Route::post('/login-aklap',[AklapController::class, 'login']);
Route::post('/aklap-lra',[AklapController::class, 'getLra']);
Route::get('/get-aklap-lra',[AklapController::class, 'getLra']);
Route::post('/aklap-get-skpd',[AklapController::class, 'getSkpd']);

Route::get('/get-report-konsolidasi',[AklapController::class, 'reportKonsolidasi']);



