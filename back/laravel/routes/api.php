<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    //====== CREAR USUARIO ========================
    use App\Http\Controllers\UserController;
    Route::post('/register', [UserController::class, 'register']);    