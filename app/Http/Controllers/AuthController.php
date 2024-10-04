<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $attempt = auth()->attempt([
            'email'=> $email,
            'password' => $password
        ]);
        if(!$attempt){
            return response()->json([
                    'error'=> 'unauthorized'
            ],401);
        }
        $user = auth()->user();
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json(['token' => $token]);
    }
}
