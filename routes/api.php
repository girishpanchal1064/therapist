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
  Route::get('my-moods', [ApiController::class, 'myMoods']);
  Route::post('my-moods', [ApiController::class, 'storeMyMood']);
  Route::get('appointments', [ApiController::class, 'appointments']);
  Route::get('client/appointments/upcoming', [ApiController::class, 'clientUpcomingAppointments']);
  Route::get('client/appointments', [ApiController::class, 'clientAppointments']);
  Route::get('client/appointments/{id}', [ApiController::class, 'clientAppointmentShow']);
  Route::post('client/reviews', [ApiController::class, 'storeClientReview']);
  Route::get('client/reviews', [ApiController::class, 'clientReviews']);
  Route::get('therapist/appointments/upcoming', [ApiController::class, 'therapistUpcomingAppointments']);
  Route::get('therapist/appointments', [ApiController::class, 'therapistAppointments']);
  Route::get('therapist/appointments/{id}', [ApiController::class, 'therapistAppointmentShow']);
  Route::get('therapist/reviews', [ApiController::class, 'therapistReviews']);
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
  Route::get('assessments/responses', [ApiController::class, 'assessmentResponses']);
  Route::get('assessments/responses/{id}', [ApiController::class, 'assessmentResponseShow']);
  Route::get('assessments/{id}', [ApiController::class, 'assessmentShow']);
  Route::post('assessments/{id}/submit', [ApiController::class, 'assessmentSubmit']);

  // Therapist account summary
  Route::get('therapist/account-summary', [ApiController::class, 'therapistAccountSummary']);
  Route::get('therapist/availability', [ApiController::class, 'therapistOwnAvailability']);
  Route::post('therapist/availability/weekly', [ApiController::class, 'createTherapistWeeklyAvailability']);
  Route::put('therapist/availability/weekly', [ApiController::class, 'updateTherapistWeeklyAvailability']);
  Route::delete('therapist/availability/weekly/{id}', [ApiController::class, 'deleteTherapistWeeklyAvailability']);
  Route::post('therapist/availability/single-day', [ApiController::class, 'createTherapistSingleAvailability']);
  Route::put('therapist/availability/single-day', [ApiController::class, 'updateTherapistSingleAvailability']);
  Route::delete('therapist/availability/single-day/{id}', [ApiController::class, 'deleteTherapistSingleAvailability']);
  Route::post('therapist/availability/block', [ApiController::class, 'createTherapistAvailabilityBlock']);
  Route::put('therapist/availability/block', [ApiController::class, 'updateTherapistAvailabilityBlock']);
  Route::delete('therapist/availability/block/{id}', [ApiController::class, 'deleteTherapistAvailabilityBlock']);

  // Therapist session notes
  Route::get('therapist/sessions-for-notes', [ApiController::class, 'therapistSessionsForNotes']);
  Route::get('therapist/session-notes', [ApiController::class, 'therapistSessionNotes']);
  Route::post('therapist/session-notes', [ApiController::class, 'storeTherapistSessionNote']);
  Route::get('therapist/session-notes/by-session/{appointmentId}', [ApiController::class, 'showTherapistSessionNoteBySession']);
  Route::get('therapist/session-notes/{id}', [ApiController::class, 'showTherapistSessionNote']);
  Route::put('therapist/session-notes/{id}', [ApiController::class, 'updateTherapistSessionNote']);
});
