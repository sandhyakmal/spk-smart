<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\HasilPerhitunganController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');
});


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('periode')->group(function () {
        Route::get('/', [PeriodeController::class, 'index'])
            ->name('periode.index');

        Route::get('/create', [PeriodeController::class, 'create'])
            ->name('periode.create');

        Route::post('/', [PeriodeController::class, 'store'])
            ->name('periode.store');

        Route::get('/{periode}/edit', [PeriodeController::class, 'edit'])
            ->name('periode.edit');

        Route::put('/{periode}', [PeriodeController::class, 'update'])
            ->name('periode.update');

        Route::delete('/{periode}', [PeriodeController::class, 'destroy'])
            ->name('periode.destroy');
    });

    Route::prefix('kriteria')->group(function () {
        Route::get('/', [KriteriaController::class, 'index'])
            ->name('kriteria.index');

        Route::get('/create', [KriteriaController::class, 'create'])
            ->name('kriteria.create');

        Route::post('/', [KriteriaController::class, 'store'])
            ->name('kriteria.store');

        Route::get('/{kriteria}/edit', [KriteriaController::class, 'edit'])
            ->name('kriteria.edit');

        Route::put('/{kriteria}', [KriteriaController::class, 'update'])
            ->name('kriteria.update');

        Route::delete('/{kriteria}', [KriteriaController::class, 'destroy'])
            ->name('kriteria.destroy');
    });

    Route::prefix('kriteria-sub')->group(function () {
        Route::get('/', [SubKriteriaController::class, 'index'])
            ->name('kriteria-sub.index');

        Route::get('/create', [SubKriteriaController::class, 'create'])
            ->name('kriteria-sub.create');

        Route::post('/', [SubKriteriaController::class, 'store'])
            ->name('kriteria-sub.store');

        Route::get('/{subKriteria}/edit', [SubKriteriaController::class, 'edit'])
            ->name('kriteria-sub.edit');

        Route::put('/{subKriteria}', [SubKriteriaController::class, 'update'])
            ->name('kriteria-sub.update');

        Route::delete('/{subKriteria}', [SubKriteriaController::class, 'destroy'])
            ->name('kriteria-sub.destroy');
    });

    Route::prefix('alternatif')->group(function () {
        Route::get('/', [AlternatifController::class, 'index'])
            ->name('alternatif.index');

        Route::get('/create', [AlternatifController::class, 'create'])
            ->name('alternatif.create');

        Route::post('/', [AlternatifController::class, 'store'])
            ->name('alternatif.store');

        Route::get('/{alternatif}/edit', [AlternatifController::class, 'edit'])
            ->name('alternatif.edit');

        Route::put('/{alternatif}', [AlternatifController::class, 'update'])
            ->name('alternatif.update');

        Route::delete('/{alternatif}', [AlternatifController::class, 'destroy'])
            ->name('alternatif.destroy');
    });

    Route::get('/perhitungan', [PerhitunganController::class, 'index'])
        ->name('perhitungan.index');


    Route::get('/hasil-perhitungan', [HasilPerhitunganController::class, 'index'])
        ->name('hasil-perhitungan.index');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});