<?php
    namespace App\Http\Controllers\Auth;

    use App\Models\User;
    use Illuminate\Support\Str;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Password;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Auth\Events\PasswordReset;

    class PasswordResetController extends Controller {
        public function showResetForm(Request $request) {
            return view('auth.passwords.reset')->with(
                ['token' => $request->token, 'email' => $request->email]
            );
        }

        public function sendResetLinkEmail(Request $request) {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Enlace de restablecimiento enviado a tu correo.'])
                : response()->json(['error' => 'Error al enviar el enlace.'], 500);
        }

        public function resetPassword(Request $request) {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'token' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? response()->json(['message' => 'Contraseña actualizada correctamente.'])
                : response()->json(['error' => 'Error al restablecer la contraseña.'], 500);
        }
    }