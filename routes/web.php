<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Konselor;
use App\Models\Jadwal;
use App\Models\Appointment;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KonselorController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;


Route::get('/', function () {
    $usersCount = \App\Models\User::count();
    $konselorsCount = \App\Models\Konselor::count();
    $jadwalsCount = \App\Models\Jadwal::count();
    $appointmentsCount = \App\Models\Appointment::count();

    return view('welcome', compact('usersCount', 'konselorsCount', 'jadwalsCount', 'appointmentsCount'));
});

Route::resource('users', UserController::class);
Route::resource('konselors', KonselorController::class);
Route::resource('jadwals', JadwalController::class);
Route::resource('appointments', AppointmentController::class);
Route::resource('feedback', FeedbackController::class);

