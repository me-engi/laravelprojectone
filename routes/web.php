<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Student CRUD Resource Routes
Route::resource('students', StudentController::class);
