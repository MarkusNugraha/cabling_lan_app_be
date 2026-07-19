<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PositionController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('user', UserController::class);
Route::apiResource('section', SectionController::class);
Route::apiResource('location', LocationController::class);
Route::apiResource('position', PositionController::class);

