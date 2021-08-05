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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//
//});
//Route::middleware('role:admin')->group(function () {
    Route::resources([
         'event' => \App\Http\Controllers\EventController::class
    ]);
//    Route::resource('event',\App\Http\Controllers\EventController::class);
//});

//user
Route::prefix('/user')->group( function () {
    Route::post('/register' , [\App\Http\Controllers\Api\RegisterController::class  , 'register']);
    Route::post('/login' , [\App\Http\Controllers\Api\LoginController::class , 'login']);
    Route::middleware('auth:api')->get('/all',[\App\Http\Controllers\Api\UserController::class, 'index']);
    Route::middleware('auth:api')->get('/current',[\App\Http\Controllers\Api\UserController::class , 'currentUser']);

});
