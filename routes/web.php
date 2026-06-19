<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendaftaranController;                    // ← tambah ini
use App\Http\Controllers\Admin\EventController as AdminEventController; // ← tambah ini

Route::get('/', function () {
    return view('welcome');
});

//Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

//Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Google OAuth
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

//Route Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

//Route Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ===== PENDAFTARAN =====                                          // ← tambah ini
Route::get('/daftar/{id_event}', [PendaftaranController::class, 'showForm'])->name('pendaftaran.form');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/daftar/sukses/{id}', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');

// ===== ADMIN =====                                               // ← tambah ini
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('event', AdminEventController::class);
});