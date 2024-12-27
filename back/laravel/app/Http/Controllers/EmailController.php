<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $email = $request->input('email');

        Mail::raw('Hola', function ($message) use ($email) {
            $message->to($email)  // Aquí usamos el email recibido del frontend
                    ->subject('Asunto del correo');
        });

        return response()->json(['message' => 'Correo enviado correctamente'], 200);
    }
}