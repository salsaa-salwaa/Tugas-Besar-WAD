<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthViewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KonselorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK ---
Route::get('/', function () { return view('welcome'); });

// --- RUTE AUTENTIKASI ---
Route::get('login', [AuthViewsController::class, 'showLoginForm'])->name('login');
Route::get('register', [AuthViewsController::class, 'showRegisterForm'])->name('register');
Route::post('login', [AuthViewsController::class, 'login']);
Route::post('register', [AuthViewsController::class, 'register']);
Route::post('logout', [AuthViewsController::class, 'logout'])->name('logout');

// =========================================================================
//  PERBAIKAN UTAMA ADA PADA STRUKTUR DI BAWAH INI
// =========================================================================

// --- RUTE YANG BISA DIAKSES SEMUA PERAN (SETELAH LOGIN) ---
Route::middleware('auth')->group(function () {

    // Dashboard utama (pengalih peran)
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('mahasiswa.dashboard');
    })->name('dashboard');

    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute umum yang bisa dilihat semua peran
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/jadwals', [JadwalController::class, 'index'])->name('jadwals.index');
});

// --- RUTE KHUSUS MAHASISWA ---
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');

    // Appointment
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Feedback
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
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

    // Admin resource management
    Route::resource('users', UserController::class);
    Route::resource('konselors', KonselorController::class);
    Route::resource('jadwals', JadwalController::class)->except(['index']); // index dibuka untuk semua

    // Admin actions on appointments & feedback
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::post('/appointments/{id}/acc', [AppointmentController::class, 'acc'])->name('appointments.acc');

    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});
