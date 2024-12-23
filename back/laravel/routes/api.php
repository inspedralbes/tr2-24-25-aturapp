<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\RolController;
    use App\Http\Controllers\TornController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\CursController;
    use App\Http\Controllers\AlertaController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\PreguntaController;
    use App\Http\Controllers\RespostasController;

    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\Auth\ForgotPasswordController;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/getUser', [UserController::class, 'index']);

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

    Route::post('/getAlertsSector', [AlertaController::class, 'getAlertsSector']);

    //====== VER PREGUNTAS ========================
    Route::get('/preguntas', [PreguntaController::class, 'index']);

    //====== PUBLICAR RESPOSTAS ===================
    Route::post('/publicar-respostas', [RespostasController::class, 'store']);

    //====== TURNOS ===============================
    Route::get('/torns', [TornController::class, 'index']);

    //====== ROLES ================================
    Route::get('rol', [RolController::class, 'index']);

    //====== GET COMPANYS =========================
    Route::get('/companys-clase/{id}', [UserController::class, 'getCompanysClase']);

    //====== VER ALUMNOS ==========================
    Route::get('/get-alumnes', [UserController::class, 'getAlumnes']);

    Route::get('/alumnes/{id}', [UserController::class, 'getAlumneById']);

    Route::get('/user/{id}/alerts', [AlertaController::class, 'getAlertsByUser']);

    //====== MODIFICAR ALUMNAT ====================
    Route::post('/alumnes/{id}', [UserController::class, 'updateAlumne']);

    //====== MIDDLEWARES ==========================
    Route::post('/update', [AlertaController::class, 'update']);

    Route::get('/show/{id}', [AlertaController::class, 'show']);

    Route::post('/alertes', [AlertaController::class, 'myAlerts']);

    Route::post('/getAlertsFilter', [AlertaController::class, 'getAlertsFilter']);


    //====== VER PREGUNTAS ========================
    Route::get('/preguntas', [PreguntaController::class, 'index']);
    
    //====== REST PASSWORD - middleware ===========
    Route::middleware('api')->group(function () {
        Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');

        Route::post('/password/reset', [ResetPasswordController::class, 'reset'])
            ->name('password.update');
    });