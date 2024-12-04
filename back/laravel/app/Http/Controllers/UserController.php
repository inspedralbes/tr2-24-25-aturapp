<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    public function register(Request $request)
{
    // Validación de los datos recibidos
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'grade' => 'required|integer|exists:curs,id',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
        ], 400);
    }

    // Crear el usuario con el ID del curso y asignar '00' por defecto al DNI
    $user = User::create([
        'nom' => $request->name,
        'cognoms' => $request->surname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'curs' => $request->grade,
        'rol' => 1,  // ID por defecto del rol
        'torn' => 1, // ID por defecto del turno
        'dni' => '00',  // Asignamos "00" como valor por defecto para el campo dni
    ]);

    return response()->json([
        'message' => 'Usuari registrat amb èxit',
        'user' => $user,
    ], 201);
}

}
