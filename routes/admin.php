<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/

// Admin Authentication Routes (outside middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Debug route to test logout
        Route::get('/logout-debug', function() {
            return response()->json([
                'message' => 'Logout debug route hit',
                'user_authenticated' => auth()->check(),
                'user_id' => auth()->id(),
                'user_email' => auth()->user() ? auth()->user()->email : 'No user'
            ]);
        })->name('logout.debug');

        // Debug route to test users data
        Route::get('/users-debug', function() {
            $users = \App\Models\User::with('roles')->get();
            return response()->json([
                'total_users' => $users->count(),
                'users' => $users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $user->roles->pluck('name')->toArray(),
                        'status' => $user->status
                    ];
                })
            ]);
        })->name('users.debug');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'backend.access'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');

    // Therapist Management
    Route::resource('therapists', TherapistController::class);
    Route::get('therapists/pending', [TherapistController::class, 'pending'])->name('therapists.pending');
    Route::post('therapists/{therapist}/approve', [TherapistController::class, 'approve'])->name('therapists.approve');
    Route::post('therapists/{therapist}/reject', [TherapistController::class, 'reject'])->name('therapists.reject');

    // Appointment Management
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments/today', [AppointmentController::class, 'today'])->name('appointments.today');
    Route::post('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');

    // Blog Management
    Route::resource('blog', BlogController::class);
    Route::get('blog/categories', [BlogController::class, 'categories'])->name('blog.categories');
    Route::post('blog/{post}/publish', [BlogController::class, 'publish'])->name('blog.publish');

    // Assessment Management
    Route::resource('assessments', AssessmentController::class);
    Route::get('assessments/results', [AssessmentController::class, 'results'])->name('assessments.results');

    // Payment Management
    Route::resource('payments', PaymentController::class);
    Route::get('payments/pending', [PaymentController::class, 'pending'])->name('payments.pending');
    Route::get('payments/reports', [PaymentController::class, 'reports'])->name('payments.reports');
    Route::post('payments/{payment}/refund', [PaymentController::class, 'refund'])->name('payments.refund');

    // Review Management
    Route::resource('reviews', ReviewController::class);
    Route::get('reviews/pending', [ReviewController::class, 'pending'])->name('reviews.pending');
    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('general', [SettingsController::class, 'general'])->name('general');
        Route::post('general', [SettingsController::class, 'updateGeneral'])->name('general.update');
        Route::get('roles', [SettingsController::class, 'roles'])->name('roles');
        Route::post('roles', [SettingsController::class, 'updateRoles'])->name('roles.update');
        Route::get('system', [SettingsController::class, 'system'])->name('system');
        Route::post('system', [SettingsController::class, 'updateSystem'])->name('system.update');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('users', [ReportController::class, 'users'])->name('users');
        Route::get('appointments', [ReportController::class, 'appointments'])->name('appointments');
        Route::get('financial', [ReportController::class, 'financial'])->name('financial');
    });

    // Role Management
    Route::resource('roles', RoleController::class);

    // Permission Management
    Route::resource('permissions', PermissionController::class);

    // User Role Management
    Route::prefix('user-roles')->name('user-roles.')->group(function () {
        Route::get('/', [UserRoleController::class, 'index'])->name('index');
        Route::post('{user}/assign', [UserRoleController::class, 'assignRole'])->name('assign');
        Route::delete('{user}/remove/{role}', [UserRoleController::class, 'removeRole'])->name('remove');
        Route::post('{user}/sync', [UserRoleController::class, 'syncRoles'])->name('sync');
    });
});
