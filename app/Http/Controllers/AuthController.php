<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;
use App\Models\Session;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Obter as credenciais
        $credentials = $request->only('email', 'password');

        // Tentar autenticar o usuário
        if (!Auth::attempt($credentials)) {
            return ApiResponse::unauthorized('Credenciais inválidas.');
        }

        // Obter o usuário autenticado
        $user = Auth::user();

        // Verificar se o e-mail foi verificado
        if (!$user->email_verified_at) {
            return ApiResponse::error('Por favor, verifique seu e-mail antes de fazer login.');
        }

        $sessionId = session()->getId();
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        $session = new Session();
        $session->id = $sessionId;
        $session->user_id = $user->id;
        $session->ip_address = $ipAddress;
        $session->user_agent = $userAgent;
        $session->last_activity = time();

        $session->payload = json_encode([]);
        $session->save();

        $token = $user->createToken($user->name, ['*'], now()->addDay())->plainTextToken;

        // Retornar resposta de sucesso
        return ApiResponse::success([
            'user' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        // Remove o token de autenticação
        $request->user()->tokens()->delete();

        session()->forget('user_id');
        $userId = $request->user()->id;

        $deleted = Session::where('user_id', $userId)->delete();

        if ($deleted) {
            return ApiResponse::success('Logout realizado com sucesso.');
        } else {
            return ApiResponse::error('Sessão não encontrada ou já removida.');
        }
    }



    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $verificationToken = Str::random(64);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_token' => $verificationToken,
        ]);

        Mail::to($user->email)->send(new VerificationEmail($user));

        return ApiResponse::success('Usuário registrado com sucesso. Por favor, verifique seu e-mail.');
    }

    public function verifyEmail($token)
    {
        Log::info('Verificando token: ' . $token);
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return ApiResponse::error('Token inválido.');
        }

        if ($user->email_verified_at) {
            return ApiResponse::error('Este e-mail já foi verificado.');
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Log::info('Usuário verificado: ' . $user->email);

        return ApiResponse::success('E-mail verificado com sucesso. Agora você pode fazer login.');
    }
}
