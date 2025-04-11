<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataHalteController;
use App\Http\Controllers\FormHalteController;
use App\Http\Controllers\FormPoolController;    
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\KoridorController;
use App\Http\Controllers\HalteController;
use App\Http\Controllers\PoolController;


// Halaman Login & Logiut
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.input');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Hanya untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashadmin', function () { return view('admin.dashadmin'); })->name('admin.dashadmin');
    Route::get('/dataformhalte', [DataHalteController::class, 'data_halte'])->name('admin.dashboard.data_halte');
    Route::get('/detail_datahalte/{id}', [DataHalteController::class, 'detail_datahalte']);
    Route::get('/datahalte/filter', [DataHalteController::class, 'filter_datahalte'])->name('filter_datahalte');
    Route::get('/export-pdf', [DataHalteController::class, 'exportPDF'])->name('export_pdf');
    Route::get('/export-excel', [DataHalteController::class, 'exportExcel'])->name('export_excel');



    Route::get('/pengawas', [PengawasController::class, 'list_pengawas'])->name('admin.pengawas.list_pengawas');
    Route::post('/pengawas/store', [PengawasController::class, 'store'])->name('pengawas.store');
    Route::put('/pengawas/{id}', [PengawasController::class, 'update'])->name('pengawas.update');
    Route::delete('/pengawas/{id}', [PengawasController::class, 'destroy'])->name('pengawas.destroy');

    Route::get('/shift', [ShiftController::class, 'list_shift'])->name('admin.shift.list_shift');
    Route::post('/shift/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::put('/shift/{id}', [ShiftController::class, 'update'])->name('shift.update');
    Route::delete('/shift/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy');

    Route::get('/koridor', [KoridorController::class, 'list_koridor'])->name('admin.koridor.list_koridor');
    Route::post('/koridor/store', [KoridorController::class, 'store'])->name('koridor.store');
    Route::put('/koridor/{id}', [KoridorController::class, 'update'])->name('koridor.update');
    Route::delete('/koridor/{id}', [KoridorController::class, 'destroy'])->name('koridor.destroy');
    
    Route::get('/halte', [HalteController::class, 'list_halte'])->name('admin.halte.list_halte');
    Route::post('/halte/store', [HalteController::class, 'store'])->name('halte.store');
    Route::put('/halte/{id}', [HalteController::class, 'update'])->name('halte.update');
    Route::delete('/halte/{id}', [HalteController::class, 'destroy'])->name('halte.destroy');

    Route::get('/pool', [PoolController::class, 'list_pool'])->name('admin.pool.list_pool');
    Route::post('/pool/store', [PoolController::class, 'store'])->name('pool.store');
    Route::put('/pool/{id}', [PoolController::class, 'update'])->name('pool.update');
    Route::delete('/pool/{id}', [PoolController::class, 'destroy'])->name('pool.destroy');

});

// Hanya untuk petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/homeuser', function () { return view('user.homeuser'); })->name('user.homeuser');

    // Form Halte
    Route::get('/halteuser', [FormHalteController::class, 'formhalte'])->name('halteuser');
    Route::get('/get-halte-by-koridor/{koridorId}', [FormHalteController::class, 'getHalteByKoridor']);
    Route::post('/halteuser/store', [FormHalteController::class, 'store'])->name('formhalte.store');

    // Form Pool
    Route::get('/pooluser', [FormPoolController::class, 'formpool'])->name('pooluser');
});