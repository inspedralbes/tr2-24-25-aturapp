<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\Auth\PasswordResetController;

    Route::get('/', function () {
        return view('welcome');
    });

    //====== VERIFICAR EMAIL ======================
    Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');

    //====== RESETEAR PASSWORD ====================
    Route::prefix('password')->group(function () {
        Route::post('/solicitar', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
        
        Route::get('/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        
        Route::post('/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');
    });