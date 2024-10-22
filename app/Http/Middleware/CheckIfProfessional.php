<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Profissional; // Importar o modelo Profissional

class CheckIfProfessional
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && Profissional::where('email', $request->user()->email)->exists()) {
            return $next($request);
        }

        return response()->json(['message' => 'Acesso negado'], 403);
    }
}
