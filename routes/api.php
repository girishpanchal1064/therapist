<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('forgot-password', [ApiController::class, 'forgotPassword']);
Route::post('reset-password', [ApiController::class, 'resetPassword']);

Route::middleware('auth:api')->group(function () {
  Route::post('logout', [ApiController::class, 'logout']);
  Route::get('me', [ApiController::class, 'me']);
});
