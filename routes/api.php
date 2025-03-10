<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('user')->group(function(){

    Route::post('logout',[AuthController::class,'logout'])->name('user.logout');
    
});

Route::post('user/login',[AuthController::class,'login']);
Route::post('user/register',[AuthController::class,'register'])->name('user.register');
