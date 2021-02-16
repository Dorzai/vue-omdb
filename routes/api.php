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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/favorite/show', [FavoriteController::class, 'show']);
Route::prefix('favorites')->group(function() {
    Route::get('/show', [FavoriteController::class, 'show']);
    Route::post('/store', [FavoriteController::class, 'store']);
    Route::put('/destroy/{id}', [FavoriteController::class, 'destroy']);
});
