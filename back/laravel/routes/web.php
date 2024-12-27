<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\Auth\PasswordResetController;

    Route::get('/', function () {
        return view('welcome');
    });

    //====== VERIFICAR EMAIL ======================
    Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');