<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => '/', 'as' => 'api.'], function () {
    Route::get('data/{date}', [\App\Http\Controllers\Api\LottoController::class, 'data']);
    Route::get('number/{number}', [\App\Http\Controllers\Api\LottoController::class, 'number']);
});
