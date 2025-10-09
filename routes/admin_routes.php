<?php

declare(strict_types=1);

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::resource('users', UserController::class);
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::resource('admins', AdminController::class);
Route::resource('groups', GroupController::class);
Route::resource('category', CategoryController::class);
Route::resource('activity', ActivityController::class);
