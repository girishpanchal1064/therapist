<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\TherapistController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Therapist\DashboardController as TherapistDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Therapist\AvailabilityController as TherapistAvailabilityController;
use App\Http\Controllers\Therapist\SessionController as TherapistSessionController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/admin/login', function () {
        return view('admin.login');
    })->name('admin.login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile/image', [ProfileController::class, 'deleteProfileImage'])->name('profile.image.delete');
});

// Admin dashboard (SuperAdmin and Admin share)
Route::middleware(['auth', 'role:SuperAdmin|Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});
// Therapist dashboard (controller)
Route::middleware(['auth', 'role:Therapist'])->prefix('therapist')->name('therapist.')->group(function () {
    Route::get('/dashboard', [TherapistDashboardController::class, 'index'])->name('dashboard');
});
// Therapist-specific profile routes
Route::middleware(['auth', 'role:Therapist'])->prefix('therapist')->name('therapist.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile/image', [ProfileController::class, 'deleteProfileImage'])->name('profile.image.delete');
    Route::get('/dashboard', [TherapistDashboardController::class, 'index'])->name('dashboard');

    // Availability module
    Route::prefix('availability')->name('availability.')->group(function () {
        // Set Availability (Week wise)
        Route::get('/set', [TherapistAvailabilityController::class, 'set'])->name('set');
        Route::post('/set', [TherapistAvailabilityController::class, 'storeSet'])->name('set.store');
        Route::put('/set/{availability}', [TherapistAvailabilityController::class, 'updateSet'])->name('set.update');
        Route::delete('/set/{availability}', [TherapistAvailabilityController::class, 'destroySet'])->name('set.destroy');

        // Single Availability (Single Day)
        Route::get('/single', [TherapistAvailabilityController::class, 'single'])->name('single');
        Route::post('/single', [TherapistAvailabilityController::class, 'storeSingle'])->name('single.store');
        Route::put('/single/{availability}', [TherapistAvailabilityController::class, 'updateSingle'])->name('single.update');
        Route::delete('/single/{availability}', [TherapistAvailabilityController::class, 'destroySingle'])->name('single.destroy');

        // Block Availability
        Route::get('/block', [TherapistAvailabilityController::class, 'block'])->name('block');
        Route::post('/block/date', [TherapistAvailabilityController::class, 'storeBlockDate'])->name('block.date.store');
        Route::put('/block/date/{block}', [TherapistAvailabilityController::class, 'updateBlockDate'])->name('block.date.update');
        Route::post('/block/slot', [TherapistAvailabilityController::class, 'storeBlockSlots'])->name('block.slot.store');
        Route::put('/block/slot/{block}', [TherapistAvailabilityController::class, 'updateBlockSlots'])->name('block.slot.update');
        Route::post('/block/{block}/toggle', [TherapistAvailabilityController::class, 'toggleBlock'])->name('block.toggle');
        Route::delete('/block/{block}', [TherapistAvailabilityController::class, 'destroyBlock'])->name('block.destroy');
    });

    // Online Sessions module
    Route::prefix('sessions')->name('sessions.')->group(function () {
        Route::get('/', [TherapistSessionController::class, 'index'])->name('index');
    });
});
// Client dashboard (controller)
Route::middleware(['auth', 'role:Client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
});

// Therapist listing and booking routes
Route::get('/therapists', [TherapistController::class, 'index'])->name('therapists.index');
Route::get('/therapists/{id}', [TherapistController::class, 'show'])->name('therapists.show');

// Booking routes
Route::middleware('auth')->group(function () {
    Route::get('/book/{therapist}', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/book', [BookingController::class, 'bookAppointment'])->name('booking.store');
    Route::get('/booking/slots', [BookingController::class, 'getAvailableSlots'])->name('booking.slots');
});

// Payment routes
Route::middleware('auth')->group(function () {
    Route::get('/payment/create/{appointment}', [App\Http\Controllers\PaymentController::class, 'showPaymentForm'])->name('payment.create');
    Route::post('/payment/process', [App\Http\Controllers\PaymentController::class, 'createPayment'])->name('payment.process');
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failure', [App\Http\Controllers\PaymentController::class, 'paymentFailure'])->name('payment.failure');
    Route::post('/payment/refund', [App\Http\Controllers\PaymentController::class, 'refundPayment'])->name('payment.refund');
});

// Chat routes
Route::middleware('auth')->group(function () {
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{conversation}/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/conversation/create', [App\Http\Controllers\ChatController::class, 'createConversation'])->name('chat.conversation.create');
});

// Placeholder routes for other pages
Route::get('/assessments', [App\Http\Controllers\Web\AssessmentController::class, 'index'])->name('assessments.index');
Route::get('/assessments/{slug}', [App\Http\Controllers\Web\AssessmentController::class, 'show'])->name('assessments.show');
Route::get('/assessments/{slug}/start', [App\Http\Controllers\Web\AssessmentController::class, 'start'])->name('assessments.start');

Route::get('/blog', [App\Http\Controllers\Web\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\Web\BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{slug}', [App\Http\Controllers\Web\BlogController::class, 'category'])->name('blog.category');

Route::get('/about', function () {
    return view('web.about');
})->name('about');
