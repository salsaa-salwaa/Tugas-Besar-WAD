<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK ---
Route::get('/', function () { return view('welcome'); });

// --- RUTE AUTENTIKASI ---
Route::get('login', [\App\Http\Controllers\AuthViewsController::class, 'showLoginForm'])->name('login');
Route::get('register', [\App\Http\Controllers\AuthViewsController::class, 'showRegisterForm'])->name('register');
Route::post('login', [\App\Http\Controllers\AuthViewsController::class, 'login']);
Route::post('register', [\App\Http\Controllers\AuthViewsController::class, 'register']);
Route::post('logout', [\App\Http\Controllers\AuthViewsController::class, 'logout'])->name('logout');


// --- RUTE YANG BISA DIAKSES SEMUA PERAN (SETELAH LOGIN) ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('mahasiswa.dashboard');
    })->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute yang bisa diakses SEMUA PERAN untuk melihat daftar
    Route::get('/appointments', [\App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/jadwals', [\App\Http\Controllers\JadwalController::class, 'index'])->name('jadwals.index');
    
    // PERBAIKAN: Rute Edit & Update Sesi sekarang bisa diakses semua peran.
    // Izin akses akan dicek di dalam Controller.
    Route::get('/appointments/{appointment}/edit', [\App\Http\Controllers\AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'update'])->name('appointments.update');
});


// --- RUTE KHUSUS MAHASISWA ---
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () { return view('mahasiswa.dashboard'); })->name('mahasiswa.dashboard');

    // Mahasiswa hanya bisa membuat sesi baru.
    Route::get('/appointments/create', [\App\Http\Controllers\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [\App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');
    
    Route::get('/feedback/create', [\App\Http\Controllers\FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
});


// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard', [
            'usersCount' => \App\Models\User::count(),
            'konselorsCount' => \App\Models\Konselor::count(),
            'jadwalsCount' => \App\Models\Jadwal::count(),
            'appointmentsCount' => \App\Models\Appointment::count(),
            'feedbackCount' => \App\Models\Feedback::count(),
        ]);
    })->name('admin.dashboard');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('konselors', \App\Http\Controllers\KonselorController::class);
    Route::resource('jadwals', \App\Http\Controllers\JadwalController::class)->except(['index']);

    // Aksi hapus spesifik oleh Admin
    Route::delete('/appointments/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::delete('/feedback/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedback.destroy');
});
