<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.mahasiswa.auth-login');
});

Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::get('/mahasiswa/login', [AuthController::class, 'showMahasiswaLoginForm'])->name('mahasiswa.login');
Route::post('/mahasiswa/login', [AuthController::class, 'mahasiswaLogin']);

Route::get('/dosen/login', [AuthController::class, 'showDosenLoginForm'])->name('dosen.login');
Route::post('/dosen/login', [AuthController::class, 'dosenLogin']);

// Rute untuk admin
Route::middleware('auth:admin')->get('/admin/dashboard', function () {
    return view('pages.dashboard', ['type_menu' => 'admin']);
})->name('admin.dashboard');

// Rute untuk mahasiswa
Route::middleware('auth:student')->get('/mahasiswa/dashboard', function () {
    return view('pages.dashboard', ['type_menu' => 'mahasiswa']);
})->name('mahasiswa.dashboard');

// Rute untuk dosen
Route::middleware('auth:lecturer')->get('/dosen/dashboard', function () {
    return view('pages.dashboard', ['type_menu' => 'dosen']);
})->name('dosen.dashboard');

// Route logout
Route::post('/logout', function () {
    $guard = null;

    // Menentukan guard yang aktif berdasarkan siapa yang login
    if (Auth::guard('admin')->check()) {
        $guard = 'admin';
    } elseif (Auth::guard('student')->check()) {
        $guard = 'student';
    } elseif (Auth::guard('lecturer')->check()) {
        $guard = 'lecturer';
    }

    // Logout pengguna yang sedang aktif
    Auth::guard($guard)->logout();

    // Redirect ke halaman login yang sesuai berdasarkan guard
    if ($guard === 'admin') {
        return redirect()->route('admin.login');
    } elseif ($guard === 'student') {
        return redirect()->route('mahasiswa.login');
    } elseif ($guard === 'lecturer') {
        return redirect()->route('dosen.login');
    }

    // Default, jika tidak ada guard yang cocok
    return redirect('/');
})->name('logout');
