<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenController;

// Halaman dashboard
Route::get('/', [ScreenController::class, 'dashboard'])->name('dashboard');

// Halaman Bring In/Out
Route::get('/bringin', function () {
    return view('bringin');
})->name('bringin');

// Halaman Screen
Route::post('/screen/save', [ScreenController::class, 'store'])->name('screen.save');

// Halaman Screen Overview
Route::get('/overview', [ScreenController::class, 'overview'])->name('overview');

// Halaman Screen Approval
Route::get('/approval', [ScreenController::class, 'approval'])->name('approval');

// Halaman Screen Approval Detail
Route::get('/approval/{id}', [ScreenController::class, 'showApproval'])->name('approval.show');

// approval route
// Approval routes
Route::get('/approval/{id}', [ScreenController::class, 'showApproval'])->name('approval.show');
Route::post('/approval/approve/{id}', [ScreenController::class, 'approve'])->name('approval.approve');
Route::post('/approval/reject/{id}', [ScreenController::class, 'reject'])->name('approval.reject');

// Halaman Screen Overview Detail
Route::get('/overview/{id}', [ScreenController::class, 'showOverview'])->name('overview.show');

// Export PDF route
Route::get('/overview/{id}/pdf', [ScreenController::class, 'exportPDF'])->name('overview.exportPdf');

