<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FacturaController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::prefix('/user')->group(function() {
    Route::post('/login', 'App\Http\Controllers\LoginController@login');
});

Route::middleware('auth:api')->group( function () {
    Route::apiResource('facturas', FacturaController::class);
    Route::get('/topBuyClients', 'App\Http\Controllers\FacturaController@topBuyClients');
    Route::get('/topBuyArticles', 'App\Http\Controllers\FacturaController@topBuyArticles');
    Route::get('/forWeek', 'App\Http\Controllers\FacturaController@forWeek');

});