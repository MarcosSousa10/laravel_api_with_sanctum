<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            $user = User::where('email', $request->email)->first();
            $token = Password::broker()->createToken($user);

            return view('auth.reset-password')->with([
                'token' => $token,
                'email' => $request->email
            ]);
        }

        return back()->withErrors(['email' => trans($response)]);
    }
}
