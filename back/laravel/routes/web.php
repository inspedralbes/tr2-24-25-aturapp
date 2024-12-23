<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;

    Route::get('/', function () {
        return view('welcome');
    });

    //====== VERIFICAR EMAIL ======================
    Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');

    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
