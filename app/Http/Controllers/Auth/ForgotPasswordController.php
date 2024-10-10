<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails; // Importando o trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Envia o link de redefinição de senha
        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            // Gera o token de redefinição de senha
            $user = User::where('email', $request->email)->first();
            $token = Password::broker()->createToken($user);

            // Redireciona para a view de redefinição de senha
            return view('auth.reset-password')->with([
                'token' => $token,
                'email' => $request->email // Passa o e-mail aqui
            ]);
        }

        return back()->withErrors(['email' => trans($response)]);
    }
}
