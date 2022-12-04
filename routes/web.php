<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KlinikController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

// Pasien
Route::get('pasien', [PasienController::class, 'index'])
    ->name('pasien')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('pasien/create', [PasienController::class, 'create'])
    ->name('pasien.create')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::post('pasien', [PasienController::class, 'store'])
    ->name('pasien.store')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('pasien/{id}/edit', [PasienController::class, 'edit'])
    ->name('pasien.edit')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('pasien/{id}', [PasienController::class, 'update'])
    ->name('pasien.update')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::delete('pasien/{id}', [PasienController::class, 'destroy'])
    ->name('pasien.destroy')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('pasien/{id}/restore', [PasienController::class, 'restore'])
    ->name('pasien.restore')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

// Klinik
Route::get('klinik', [KlinikController::class, 'index'])
    ->name('klinik')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('klinik/create', [KlinikController::class, 'create'])
    ->name('klinik.create')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::post('klinik', [KlinikController::class, 'store'])
    ->name('klinik.store')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('klinik/{id}/edit', [KlinikController::class, 'edit'])
    ->name('klinik.edit')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('klinik/{id}', [KlinikController::class, 'update'])
    ->name('klinik.update')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::delete('klinik/{id}', [KlinikController::class, 'destroy'])
    ->name('klinik.destroy')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('klinik/{id}/restore', [KlinikController::class, 'restore'])
    ->name('klinik.restore')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

// Dokter
Route::get('dokter', [DokterController::class, 'index'])
    ->name('dokter')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('dokter/create', [DokterController::class, 'create'])
    ->name('dokter.create')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::post('dokter', [DokterController::class, 'store'])
    ->name('dokter.store')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('dokter/{id}/edit', [DokterController::class, 'edit'])
    ->name('dokter.edit')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('dokter/{id}', [DokterController::class, 'update'])
    ->name('dokter.update')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::delete('dokter/{id}', [DokterController::class, 'destroy'])
    ->name('dokter.destroy')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('dokter/{id}/restore', [DokterController::class, 'restore'])
    ->name('dokter.restore')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

// Admin

Route::get('admin', [AdminController::class, 'index'])
    ->name('admin')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('admin/create', [AdminController::class, 'create'])
    ->name('admin.create')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::post('admin', [AdminController::class, 'store'])
    ->name('admin.store')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('admin/{user}/edit', [AdminController::class, 'edit'])
    ->name('admin.edit')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('admin/{user}', [AdminController::class, 'update'])
    ->name('admin.update')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::delete('admin/{user}', [AdminController::class, 'destroy'])
    ->name('admin.destroy')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('admin/{user}/restore', [AdminController::class, 'restore'])
    ->name('admin.restore')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

// Pendaftaran

Route::get('pendaftaran', [PendaftaranController::class, 'index'])
    ->name('pendaftaran')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('pendaftaran/create', [PendaftaranController::class, 'create'])
    ->name('pendaftaran.create')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::post('pendaftaran', [PendaftaranController::class, 'store'])
    ->name('pendaftaran.store')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::get('pendaftaran/{user}/edit', [PendaftaranController::class, 'edit'])
    ->name('pendaftaran.edit')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('pendaftaran/{user}', [PendaftaranController::class, 'update'])
    ->name('pendaftaran.update')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::delete('pendaftaran/{user}', [PendaftaranController::class, 'destroy'])
    ->name('pendaftaran.destroy')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);

Route::put('pendaftaran/{user}/restore', [PendaftaranController::class, 'restore'])
    ->name('pendaftaran.restore')
    ->middleware([\App\Http\Middleware\OnlyAdminMiddleware::class]);
