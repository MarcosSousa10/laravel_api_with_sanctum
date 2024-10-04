<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(
        [
            'status' => 'ok',
            'menssage' => 'Api is running'
        ],
        200
    );
});
Route::apiResource('cliente',ClientController::class);
