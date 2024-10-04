<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return ApiResponse::success('API is running');
})->middleware('auth:sanctum');
//Route::apiResource('cliente', ClientController::class)->middleware('auth:sanctum');
Route::get('cliente', [ClientController::class,"index"])->middleware(['auth:sanctum','ability:clients:list']);
Route::post('cliente', [ClientController::class,"store"])->middleware('auth:sanctum');
Route::get('cliente/{client}', [ClientController::class,"show"])->middleware(['auth:sanctum','ability:clients:detail']);
Route::put('cliente/{client}', [ClientController::class,"update"])->middleware('auth:sanctum');
Route::delete('cliente/{client}', [ClientController::class,"delete"])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
