<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PoscosAuthController;
use App\Http\Controllers\Auth\RegisterController;

// Redirect root URL ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// route untuk dashboard
Route::get('/dashboard', [ScreenController::class, 'dashboard'])->name('dashboard');

// ==============================
// Auth - User Biasa (Default Guard)
// ==============================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ==============================
// Auth - Poscos Guard
// ==============================
Route::prefix('poscos')->name('poscos.')->middleware('guest')->group(function () {
    Route::get('/login', [PoscosAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PoscosAuthController::class, 'login']);
});

// ==============================
// Untuk User Login Biasa (guard default)
// ==============================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ScreenController::class, 'dashboard'])->name('dashboard');

    Route::get('/bringin', [ScreenController::class, 'bringin'])->name('bringin');


    Route::post('/screen/save', [ScreenController::class, 'store'])->name('screen.save');

    Route::get('/overview', [ScreenController::class, 'overview'])->name('overview');
    Route::get('/overview/{id}', [ScreenController::class, 'showOverview'])->name('overview.show');
    Route::get('/overview/{id}/pdf', [ScreenController::class, 'exportPDF'])->name('overview.exportPdf');

    Route::get('/approval', [ScreenController::class, 'approval'])->name('approval');
    Route::get('/approval/{id}', [ScreenController::class, 'showApproval'])->name('approval.show');
    Route::post('/approval/approve/{id}', [ScreenController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/reject/{id}', [ScreenController::class, 'reject'])->name('approval.reject');

    // Optional user-specific approval page
    Route::get('/approval/user', [ScreenController::class, 'approvalUser']);
});

// ==============================
// Untuk User Login Poscos (guard poscos)
// ==============================
Route::middleware(['auth.poscos'])->group(function () {
    Route::get('/approval/poscos', [ScreenController::class, 'approvalPoscos']);
});


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


