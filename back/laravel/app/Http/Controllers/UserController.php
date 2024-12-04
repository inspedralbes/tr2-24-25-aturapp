<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    public function register(Request $request) {
        $blacklisted = Blacklist::where('email', $request->email)->exists();
        if ($blacklisted) {
            return response()->json([
                'error' => 'El correu electronic esta dintre de la llista negra',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'grade' => 'required|integer|exists:curs,id',
            'dni' => 'required|string|unique:users,dni|max:10',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'nom' => $request->name,
            'cognoms' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'curs' => $request->grade,
            'rol' => 1,
            'torn' => 1,
            'dni' => $request->dni,
        ]);

        return response()->json([
            'message' => 'Usuari registrat amb èxit',
        ], 201);
    }
}