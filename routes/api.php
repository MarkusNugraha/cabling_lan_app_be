<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\DeviceCategoryController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\VlanController;
use App\Http\Controllers\Api\SwitchController;
use App\Http\Controllers\Api\SwitchPortController;
use App\Http\Controllers\Api\VoipController;
use App\Http\Controllers\Api\ComputerController;


Route::apiResource('user', UserController::class);
Route::apiResource('section', SectionController::class);
Route::apiResource('location', LocationController::class);
Route::apiResource('position', PositionController::class);
Route::apiResource('device_category', DeviceCategoryController::class);
Route::apiResource('device', DeviceController::class);
Route::apiResource('vlan', VlanController::class);
Route::apiResource('switch', SwitchController::class);
Route::apiResource('switch_port', SwitchPortController::class);
Route::apiResource('voip', VoipController::class);
Route::apiResource('computer', ComputerController::class);
