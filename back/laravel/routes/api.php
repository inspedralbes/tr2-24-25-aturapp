<?php
    use App\Http\Controllers\AlertaController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\CursController;
    use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//====== HACER LOGIN ==========================
Route::post('/login', [UserController::class, 'login']);

//====== CREAR USUARIO ========================
Route::post('/register', [UserController::class, 'register']);

//====== OBTENER CURSOS =======================
Route::get('/cursos', [CursController::class, 'index']);
Route::apiResource('users', UserController::class);
Route::apiResource('cursos', CursController::class);

    //====== HACER LOGIN ==========================
    Route::post('/login', [UserController::class, 'login']);

    //====== HACER ALERTA =========================
    Route::post('/alert', [AlertaController::class, 'store']);

    Route::post('/alertes', [AlertaController::class, 'myAlerts']);

    Route::get('/show/{id}', [AlertaController::class, 'show']);
    //====== VER PREGUNTAS ========================
    Route::get('/preguntas',[PreguntaController::class, 'index']);