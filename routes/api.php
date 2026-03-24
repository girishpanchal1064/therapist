<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('login/customer', [ApiController::class, 'loginCustomer']);
Route::post('login/therapist', [ApiController::class, 'loginTherapist']);
Route::post('forgot-password', [ApiController::class, 'forgotPassword']);

Route::get('therapists', [ApiController::class, 'therapists']);
Route::get('therapists/{id}', [ApiController::class, 'therapistProfile']);
Route::get('therapists/{id}/availability', [ApiController::class, 'therapistAvailability']);

Route::middleware('auth:api')->group(function () {
  Route::post('reset-password', [ApiController::class, 'resetPassword']);
  Route::post('logout', [ApiController::class, 'logout']);
  Route::get('me', [ApiController::class, 'me']);
  Route::get('appointments', [ApiController::class, 'appointments']);
  Route::post('appointments', [ApiController::class, 'createAppointment']);

  // Profile
  Route::get('profile', [ApiController::class, 'profile']);
  Route::put('profile', [ApiController::class, 'updateProfile']);
  Route::patch('profile', [ApiController::class, 'updateProfile']);
  Route::post('profile/avatar', [ApiController::class, 'updateAvatar']);
  Route::get('profile/therapist', [ApiController::class, 'therapistSelfProfile']);
  Route::put('profile/therapist', [ApiController::class, 'updateTherapistProfile']);

  // Wallet
  Route::get('wallet', [ApiController::class, 'wallet']);
  Route::get('wallet/transactions', [ApiController::class, 'walletTransactions']);
  Route::post('wallet/topup-confirm', [ApiController::class, 'walletTopupConfirm']);

  // Therapist-specific
  // Assessments
  Route::get('assessments', [ApiController::class, 'assessments']);
  Route::get('assessments/{id}', [ApiController::class, 'assessmentShow']);
  Route::post('assessments/{id}/submit', [ApiController::class, 'assessmentSubmit']);
  Route::get('assessments/responses', [ApiController::class, 'assessmentResponses']);
  Route::get('assessments/responses/{id}', [ApiController::class, 'assessmentResponseShow']);

  // Therapist account summary
  Route::get('therapist/account-summary', [ApiController::class, 'therapistAccountSummary']);

  // Therapist session notes
  Route::get('therapist/sessions-for-notes', [ApiController::class, 'therapistSessionsForNotes']);
  Route::get('therapist/session-notes', [ApiController::class, 'therapistSessionNotes']);
  Route::post('therapist/session-notes', [ApiController::class, 'storeTherapistSessionNote']);
  Route::get('therapist/session-notes/{id}', [ApiController::class, 'showTherapistSessionNote']);
  Route::put('therapist/session-notes/{id}', [ApiController::class, 'updateTherapistSessionNote']);
});
