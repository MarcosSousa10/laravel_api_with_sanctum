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

        if (!Auth::attempt($credentials)) {
            return ApiResponse::unauthorized('Credenciais inválidas.');
        }

        $user = Auth::user();

        if (!$user->email_verified) {
            return ApiResponse::error('Por favor, verifique seu e-mail antes de fazer login.');
        }

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
        Log::info('Verifying token: ' . $token);
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return ApiResponse::error('Token inválido.');
        }

        if ($user->email_verified) {
            return ApiResponse::error('Este e-mail já foi verificado.');
        }

        $user->email_verified = true;
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Log::info('User verified: ' . $user->email);

        return ApiResponse::success('E-mail verificado com sucesso. Agora você pode fazer login.');
    }



}
