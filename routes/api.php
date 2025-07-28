<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\BorrowingApiController;
use \App\Http\Controllers\Api\FinesApiController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('categories', CategoryApiController::class);
Route::apiResource('books', BookApiController::class);
Route::apiResource('borrowings', BorrowingApiController::class);
Route::apiResource('fines', FinesApiController::class);