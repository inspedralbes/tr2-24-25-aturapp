<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blacklist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // public function index(User $user, Request $request) 
    // {
    //     $user = User::find($request->id);

    //     if(!$user)
    //     {
    //         return response()->json(['message' => "Error, no existeix l'usuari"], 400);
    //     }

    //     return response()->json(['user' => $user], 200);
    // }

    public function getRol($id) {
        $user = User::with('rol')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => "L'usuari no existeix"], 400);
        }

        $rolName = $user->rol;
        return response()->json(['success' => true, 'rol' => $rolName], 200);
    }

    public function register(Request $request)
    {
        $blacklisted = Blacklist::where('email', $request->email)->exists();
        if ($blacklisted) {
            return response()->json([
                'error' => 'El correu electronic està dintre de la llista negra.',
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

        $verificationToken = Str::random(32);
        $user->verification_token = $verificationToken;
        $user->save();

        $verificationUrl = route('verify.email', ['token' => $verificationToken]);

        Mail::raw(
            "Hola {$user->nom} {$user->cognoms},\n\nConfirma el teu usuari fent clic al següent enllaç:\n\n{$verificationUrl}",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject("ATURAPP | Confirma el teu usuari");
            }
        );

        return response()->json([
            'message' => 'Usuari registrat amb èxit. Si us plau, revisa el teu correu per confirmar la teva adreça.',
        ], 201);
    }

    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json([
                'error' => 'El token de verificació és invàlid o ha expirat.',
            ], 400);
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return response()->json([
            'message' => 'El correu s\'ha verificat correctament.',
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $user = Auth::user();

        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'No s\'ha verificat el correu electronic'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($user->rol == 2) {
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'nom' => $user->nom,
                    'cognom' => $user->cognoms,
                    'dni' => $user->dni,
                    'rol' => $user->rol
                ],
                'redirect_to' => '/admin',
                'token' => $token,
            ]);
        }

        $companys_clase = User::where('curs', $user->curs)->select('nom', 'cognoms', 'id')->get();

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'nom' => $user->nom,
                'cognom' => $user->cognoms,
                'curs' => $user->curs,
                'dni' => $user->dni,
                'rol' => $user->rol
            ],
            'course' => [
                'id' => $user->curs,
            ],
            'companys_clase' => $companys_clase,
            'redirect_to' => '/',
            'token' => $token,
        ]);
    }

    public function update(User $alumne, Request $request)
    {
        $validated = $request->validate([
            'alumne_id' => 'required|integer',
            'nom' => 'required|string',
            'cognom' => 'required|string',
            'telefon' => 'nullable|integer',
            'dni' => 'string|nullable'
        ]);

        $alumne = User::find($validated['alumne_id']);

        if (!$alumne) {
            return response()->json(['success' => false, 'message' => "L'alumne no existeix"]);
        }

        if ($alumne->id != $validated['alumne_id']) {
            return response()->json(['success' => false, 'message' => 'Error alumne no valid']);
        }

        $alumne->nom = $validated['nom'];
        $alumne->cognoms = $validated['cognom'];
        $alumne->telefon = $validated['telefon'] ?? $alumne->telefon;
        $alumne->dni = $validated['dni'] ?? $alumne->dni;
        $alumne->save();

        return response()->json(['success' => true, 'message' => 'Usuari editada amb èxit', 'user' => $alumne], 201);
    }
}
