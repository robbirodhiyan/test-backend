<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EpresenceController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group.
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('me', [UserController::class, 'me'])->middleware('auth:api');


Route::middleware('auth:api')->group(function () {
    Route::post('epresence', [EpresenceController::class, 'store']);
    Route::get('epresence', [EpresenceController::class, 'index']);
    Route::post('epresence/approve/{id}', [EpresenceController::class, 'approve']);
});
