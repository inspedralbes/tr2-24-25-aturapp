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

    class UserController extends Controller {
        public function register(Request $request) {
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

        public function verifyEmail($token) {
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
                'password' => 'required|string|min:5',
            ]);
        
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Credenciales incorrectas',
                ], 401);
            }
        
            $user = Auth::user();
        
            $token = $user->createToken('auth_token')->plainTextToken;
        
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->nom,
                    'surname' => $user->cognoms,
                ],
                'token' => $token,
            ]);
        }
    }