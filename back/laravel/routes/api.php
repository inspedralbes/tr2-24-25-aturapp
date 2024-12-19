<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\CursController;
    use App\Http\Controllers\AlertaController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\PreguntaController;
    use App\Http\Controllers\RespostasController;

    //====== OBTENER CURSOS =======================
    Route::get('/cursos',[CursController::class, 'index']);

    //====== HACER LOGIN ==========================
    Route::post('/login', [UserController::class, 'login']);

    //====== ALERTAS =========================
    

    //====== CREAR USUARIO ========================
    Route::post('/register', [UserController::class, 'register']);    

    //====== VER PREGUNTAS ========================
    

    //====== PUBLICAR RESPOSTAS ===================
    Route::get('/preguntas',[PreguntaController::class, 'index']);
    
    // Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/publicar-respostas', [RespostasController::class, 'store']);
        Route::post('/alert', [AlertaController::class, 'store']);
        Route::post('/alertes', [AlertaController::class, 'myAlerts']);
        Route::post('/update', [AlertaController::class, 'update']);
        Route::get('/show/{id}', [AlertaController::class, 'show']);
    // });
