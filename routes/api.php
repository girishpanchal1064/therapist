<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('login/customer', [ApiController::class, 'loginCustomer']);
Route::post('login/therapist', [ApiController::class, 'loginTherapist']);
Route::post('forgot-password', [ApiController::class, 'forgotPassword']);
Route::post('reset-password', [ApiController::class, 'resetPassword']);

Route::get('therapists', [ApiController::class, 'therapists']);
Route::get('therapists/{id}', [ApiController::class, 'therapistProfile']);
Route::get('therapists/{id}/availability', [ApiController::class, 'therapistAvailability']);

Route::middleware('auth:api')->group(function () {
  Route::post('logout', [ApiController::class, 'logout']);
  Route::get('me', [ApiController::class, 'me']);
  Route::get('appointments', [ApiController::class, 'appointments']);
  Route::post('appointments', [ApiController::class, 'createAppointment']);

  // Profile
  Route::get('profile', [ApiController::class, 'profile']);
  Route::put('profile', [ApiController::class, 'updateProfile']);
  Route::patch('profile', [ApiController::class, 'updateProfile']);
  Route::get('profile/therapist', [ApiController::class, 'therapistSelfProfile']);

  // Wallet
  Route::get('wallet', [ApiController::class, 'wallet']);
  Route::get('wallet/transactions', [ApiController::class, 'walletTransactions']);
  Route::post('wallet/topup-confirm', [ApiController::class, 'walletTopupConfirm']);

  // Assessments
  Route::get('assessments', [ApiController::class, 'assessments']);
  Route::get('assessments/{id}', [ApiController::class, 'assessmentShow']);
  Route::post('assessments/{id}/submit', [ApiController::class, 'assessmentSubmit']);
  Route::get('assessments/responses', [ApiController::class, 'assessmentResponses']);
  Route::get('assessments/responses/{id}', [ApiController::class, 'assessmentResponseShow']);
});
