<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalteController;
use App\Http\Controllers\AuthController;

// Halaman Login & Logiut
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.input');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Hanya untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashadmin', function () { return view('admin.dashadmin'); })->name('admin.dashadmin');
});

// Hanya untuk petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/homeuser', function () { return view('user.homeuser'); })->name('user.homeuser');
    Route::get('/halteuser', [HalteController::class, 'formhalte'])->name('halteuser');
    Route::get('/pooluser', function () { return view('user.pooluser'); })->name('pooluser');
});