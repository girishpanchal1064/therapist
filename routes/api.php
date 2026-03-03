<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('forgot-password', [ApiController::class, 'forgotPassword']);
Route::post('reset-password', [ApiController::class, 'resetPassword']);

// Public therapist (astrologer) endpoints
Route::get('therapists', [ApiController::class, 'therapists']);
Route::get('therapists/{id}', [ApiController::class, 'therapistProfile']);
Route::get('therapists/{id}/availability', [ApiController::class, 'therapistAvailability']);

Route::middleware('auth:api')->group(function () {
  Route::post('logout', [ApiController::class, 'logout']);
  Route::get('me', [ApiController::class, 'me']);
  Route::get('appointments', [ApiController::class, 'appointments']);
  Route::post('appointments', [ApiController::class, 'createAppointment']);
});
