<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\newEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Valida os dados recebidos do front-end
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string',
            'messageContent' => 'required|string',
        ]);

        // Envia o e-mail
        Mail::to($request->email)->send(new newEmail($request->username, $request->messageContent));

        return response()->json(['message' => 'E-mail enviado com sucesso!'], 200);
    }
}
