<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TornController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespostasController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//====== OBTENER CURSOS =======================
Route::get('/cursos', [CursController::class, 'index']);

//====== HACER LOGIN ==========================
Route::post('/login', [UserController::class, 'login']);

// ====== CREAR USUARIO ========================
Route::post('/register', [UserController::class, 'register']);

// ====== EDITAR USUARIO ========================
Route::post('/editaruser', [UserController::class, 'update']);

// ====== OBTENER ROL USUARIO =================
Route::get('/getrol/{id}', [UserController::class, 'getRol']);

//====== ALERTAS ==============================
Route::post('/alert', [AlertaController::class, 'store']);

Route::get('/getAllAlerts', [AlertaController::class, 'index']);

//====== VER PREGUNTAS ========================
Route::get('/preguntas', [PreguntaController::class, 'index']);

//====== PUBLICAR RESPOSTAS ===================
Route::post('/publicar-respostas', [RespostasController::class, 'store']);

//====== TURNOS ===============================
Route::get('/torns', [TornController::class, 'index']);


//====== VER ALUMNOS ==========================
Route::get('/get-alumnes', [UserController::class, 'getAlumnes']);

Route::get('/alumnes/{id}', [UserController::class, 'getAlumneById']);

Route::get('/user/{id}/alerts', [AlertaController::class, 'getAlertsByUser']);


//====== MODIFICAR ALUMNAT ====================
Route::post('/alumnes/{id}', [UserController::class, 'updateAlumne']);



//USAR MIDDLEWARE, SINO PUEDE COMPROMETER ALUMNOS QUE HACEN ALERTAS-----
Route::post('/alertes', [AlertaController::class, 'myAlerts']);

Route::post('/update', [AlertaController::class, 'update']);

Route::get('/show/{id}', [AlertaController::class, 'show']);
//========================================

//====== VER PREGUNTAS ========================
Route::get('/preguntas', [PreguntaController::class, 'index']);
