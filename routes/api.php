<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LineItemController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [LoginController::class, 'authenticate']);
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('product', ProductController::class);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('line-item', LineItemController::class);
    Route::apiResource('users', UserController::class);
});