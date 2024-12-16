<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
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
    Route::get('/cursos',[CursController::class, 'index']);

    //====== HACER LOGIN ==========================
    Route::post('/login', [UserController::class, 'login']);

    //====== HACER ALERTA =========================
    Route::post('/alert', [AlertaController::class, 'store']);

    //====== CREAR USUARIO ========================
    Route::post('/register', [UserController::class, 'register']);    

    //====== VER PREGUNTAS ========================
    Route::get('/preguntas',[PreguntaController::class, 'index']);

    //====== PUBLICAR RESPOSTAS ===================
    Route::post('/publicar-respostas', [RespostasController::class, 'store']);

    //====== VER PREGUNTAS ========================
    Route::get('/preguntas', [PreguntaController::class, 'index']);

    //====== VER ANALISIS =========================
    Route::get('/analisis', [RespostasController::class, 'get']);



    //====== MIDDLEWARE ============================

    //USAR MIDDLEWARE, SINO PUEDE COMPROMETER ALUMNOS QUE HACEN ALERTAS-----
    Route::post('/alertes', [AlertaController::class, 'myAlerts']);

    Route::get('/show/{id}', [AlertaController::class, 'show']);