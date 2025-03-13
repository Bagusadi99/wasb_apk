<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormHalteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengawasController;

// Halaman Login & Logiut
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.input');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Hanya untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashadmin', function () { return view('admin.dashadmin'); })->name('admin.dashadmin');
    Route::get('/pengawas', [PengawasController::class, 'list_pengawas'])->name('admin.pengawas.list_pengawas');
});

// Hanya untuk petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/homeuser', function () { return view('user.homeuser'); })->name('user.homeuser');
    Route::get('/halteuser', [FormHalteController::class, 'formhalte'])->name('halteuser');
    Route::get('/pooluser', function () { return view('user.pooluser'); })->name('pooluser');
});