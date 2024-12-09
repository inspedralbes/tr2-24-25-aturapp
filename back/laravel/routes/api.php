<?php

use App\Http\Controllers\AlertaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    //====== CREAR USUARIO ========================
    use App\Http\Controllers\UserController;
    Route::post('/register', [UserController::class, 'register']);    

    //====== OBTENER CURSOS =======================
    use App\Http\Controllers\CursController;
    Route::get('/cursos',[CursController::class, 'index']);

    //====== HACER LOGIN ==========================
    Route::post('/login', [UserController::class, 'login']);
    
    Route::post('/alert', [AlertaController::class, 'store']);