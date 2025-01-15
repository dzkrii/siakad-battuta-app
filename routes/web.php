<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Lecturer\AuthController as LecturerAuthController;

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});

// Student Routes
Route::prefix('mahasiswa')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('mahasiswa.login.submit');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('mahasiswa.logout');

    Route::middleware(['auth:student'])->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('mahasiswa.dashboard');
    });
});

// Lecturer Routes
Route::prefix('dosen')->group(function () {
    Route::get('/login', [LecturerAuthController::class, 'showLoginForm'])->name('dosen.login');
    Route::post('/login', [LecturerAuthController::class, 'login'])->name('dosen.login.submit');
    Route::post('/logout', [LecturerAuthController::class, 'logout'])->name('dosen.logout');

    Route::middleware(['auth:lecturer'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen.dashboard');
        })->name('dosen.dashboard');
    });
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.auth.login');
});

Route::get('/dosen', function () {
    return view('dosen.auth.login');
});

Route::get('/mahasiswa', function () {
    return view('mahasiswa.auth.login');
});
