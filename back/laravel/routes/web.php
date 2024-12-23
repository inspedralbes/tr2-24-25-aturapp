<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordResetController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

//====== VERIFICAR EMAIL ======================
Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');

// Rutas para restablecer contraseña
Route::prefix('password')->group(function () {
    // Ruta para solicitar el enlace de restablecimiento de contraseña
    Route::post('/solicitar', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    
    // Ruta para mostrar el formulario de restablecimiento de contraseña
    Route::get('/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    
    // Ruta para procesar el restablecimiento de la contraseña
    Route::post('/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});
