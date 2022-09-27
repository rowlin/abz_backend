<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PositionController;
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
Route::group(['prefix' => 'v1' ] , function (){
    Route::get('/users' , [UserController::class , "getAll"])->name('users');
    Route::post('/users', [UserController::class , "register"] )->name('register');
    Route::get('/users/{user_id}' , [UserController::class,"getById"])->name('user');
    Route::get('/token' ,[ AuthController::class,"getToken"])->name('token');
    Route::get('/positions' , [PositionController::class,"getAll"])->name('positions');
});
