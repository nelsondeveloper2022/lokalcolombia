<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AccountDeletionController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/comercios', [PublicController::class, 'comercios'])->name('comercios');
Route::get('/comercio/{slug}', [PublicController::class, 'comercioDetalle'])->name('comercio.detalle');
Route::get('/quienes-somos', [PublicController::class, 'quienesSomos'])->name('quienes-somos');
Route::get('/contacto', [PublicController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PublicController::class, 'enviarContacto'])->name('contacto.enviar');

// Rutas del Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/comercio', [DashboardController::class, 'comercio'])->name('dashboard.comercio');
    Route::put('/dashboard/comercio', [DashboardController::class, 'updateComercio'])->name('dashboard.comercio.update');
    Route::post('/dashboard/resend-verification', [DashboardController::class, 'resendVerification'])->name('dashboard.resend-verification');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Ruta específica para eliminación completa de cuenta
    Route::delete('/account/destroy', [AccountDeletionController::class, 'destroy'])->name('account.destroy');
});

// Rutas de administración
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::get('/comercios', [App\Http\Controllers\Admin\AdminController::class, 'comercios'])->name('comercios');
    Route::get('/categorias', [App\Http\Controllers\Admin\AdminController::class, 'categorias'])->name('categorias');
    Route::get('/usuarios', [App\Http\Controllers\Admin\AdminController::class, 'usuarios'])->name('usuarios');
});

// Ruta para búsqueda de comercios (recuperación de usuario)
Route::post('/auth/search-comercio', [App\Http\Controllers\Auth\ComercioRecoveryController::class, 'searchComercio'])
    ->name('auth.search-comercio');

require __DIR__.'/auth.php';
