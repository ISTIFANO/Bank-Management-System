<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('user')->group(function(){

    Route::post('user/logout',[AuthController::class,'logout'])->name('user.logout');
        
});

Route::post('user/login',[AuthController::class,'login']);
Route::post('Wallet/create',[WalletController::class,'createWallet']);

Route::post('user/register',[AuthController::class,'register'])->name('user.register');


Route::post('Transaction/create',[TransactionController::class,'CreateTransaction']);
