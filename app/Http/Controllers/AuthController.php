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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

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

        return ApiResponse::success([
            'user' => $user->name,
            'userId' => $user->id,
            'email' => $user->email,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
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
            Log::warning('Token inválido: ' . $token);
            return redirect()->route('verification/result', ['message' => 'Token inválido.']);
        }

        if ($user->email_verified_at) {
            Log::info('E-mail já verificado: ' . $user->email);
            return redirect()->route('verification/result', ['message' => 'Este e-mail já foi verificado.']);
        }

        // Atualizando a verificação de email
        $user->email_verified = true;
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Log::info('Usuário verificado: ' . $user->email);
        return redirect()->route('verification/result', ['message' => 'E-mail verificado com sucesso. Agora você pode fazer login.']);
    }


public function verificationResult()
{
    return view('verification.result');
}


    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Tente enviar o link de redefinição de senha
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        } else {
            return response()->json(['message' => __($status)], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return ApiResponse::success('Senha redefinida com sucesso.');
        }

        return ApiResponse::error('Erro ao redefinir a senha.', ['status' => $status]);
    }
}
