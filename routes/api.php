<?php

use App\Http\Controllers\Api\{
    UserController
};
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/**
 * Auth and Register Routes
 */
Route::post('/register', [RegisterController::class, 'store']);

Route::apiResource('/users', UserController::class);

Route::get('/', function () {
    return response()->json(['message' => 'ok']);
});