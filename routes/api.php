<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function (){
    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/{task}/submit', [TaskController::class, 'submit']);
    Route::post('tasks/{task}/replace', [TaskController::class, 'replace']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
