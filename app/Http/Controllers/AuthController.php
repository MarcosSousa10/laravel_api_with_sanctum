<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Certifique-se de importar o modelo User
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; // Para gerar o token de verificação
use App\Mail\VerificationEmail; // O e-mail que será enviado
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário
        if (!Auth::attempt($credentials)) {
            return ApiResponse::unauthorized('Credenciais inválidas.');
        }

        $user = Auth::user();

        // Verifica se o e-mail foi verificado
        if (!$user->email_verified) {
            return ApiResponse::error('Por favor, verifique seu e-mail antes de fazer login.');
        }

        // Cria o token de autenticação
        $token = $user->createToken($user->name, ['*'], now()->addDay())->plainTextToken;

        return ApiResponse::success([
            'user' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::success('Logout with success');
    }


    public function createUser(Request $request)
    {
        // Valida os dados da requisição
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Gera um token de verificação
        $verificationToken = Str::random(64);

        // Cria um novo usuário sem ativá-lo
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_token' => $verificationToken, // Salva o token
        ]);

        // Envia o e-mail de verificação
        Mail::to($user->email)->send(new VerificationEmail($user));

        return ApiResponse::success('Usuário registrado com sucesso. Por favor, verifique seu e-mail.');
    }

    public function verifyEmail($token)
    {
        Log::info('Verifying token: ' . $token); // Para depuração
        $user = User::where('email_verification_token', $token)->first();

        // Verifica se o usuário foi encontrado
        if (!$user) {
            return ApiResponse::error('Token inválido.');
        }

        // Verifica se o e-mail já foi verificado
        if ($user->email_verified) {
            return ApiResponse::error('Este e-mail já foi verificado.');
        }

        // Atualiza o status de verificação do e-mail
        $user->email_verified = true;
        $user->email_verification_token = null; // Remove o token após verificação
        $user->save();

        Log::info('User verified: ' . $user->email); // Para confirmar que o usuário foi verificado

        return ApiResponse::success('E-mail verificado com sucesso. Agora você pode fazer login.');
    }


}
