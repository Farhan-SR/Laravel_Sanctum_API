<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;

Route::post('signup', [AuthController::class,'signup']);
Route::post('farhan', [AuthController::class,'farhan']);
Route::post('login', [AuthController::class,'login']);
// Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

// group 
// Route::middleware('auth:sanctum')->group(function(){
//     Route::apiResource('posts',PostController ::class);
// });
Route::apiResource('posts',PostController ::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', PostController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::apiResource('/posts', PostController::class);