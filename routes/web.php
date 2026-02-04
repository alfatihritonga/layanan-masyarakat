<?php

use App\Http\Controllers\Admin\RelawanController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LaporanBencanaController as AdminLaporanBencanaController;
use App\Http\Controllers\Admin\ResponController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LaporanBencanaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'auth.login')->name('login')->middleware('guest');

Route::middleware(['guest'])->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])
        ->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
        ->name('auth.google.callback');
});

Route::post('logout', [GoogleAuthController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/laporan', [AdminLaporanBencanaController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{laporan}', [AdminLaporanBencanaController::class, 'show'])
            ->name('laporan.show');

        Route::patch('/laporan/{laporan}/verifikasi', [AdminLaporanBencanaController::class, 'verifikasi'])
            ->name('laporan.verifikasi');

        Route::post('/laporan/{laporan}/respon', [AdminLaporanBencanaController::class, 'respon'])
            ->name('laporan.respon');
        
        Route::post('/respon/{respon}/assign-relawan', [ResponController::class, 'assignRelawan'])
            ->name('respon.assign-relawan');

        Route::resource('relawan', RelawanController::class)->except('show');
    });

    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/laporan/index', [LaporanBencanaController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/create', [LaporanBencanaController::class, 'create'])
            ->name('laporan.create');

        Route::get('/laporan/{laporan}/show', [LaporanBencanaController::class, 'show'])
            ->name('laporan.show');

        Route::post('/laporan', [LaporanBencanaController::class, 'store'])
            ->name('laporan.store');
    });
});