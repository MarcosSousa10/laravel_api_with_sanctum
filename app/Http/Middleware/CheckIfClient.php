<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cliente; // Importar o modelo Cliente

class CheckIfClient
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
        // Verifica se o usuário está autenticado e se ele é um cliente
        if ($request->user() && Cliente::where('email', $request->user()->email)->exists()) {
            return $next($request);
        }

        // Retorna um erro 403 se não for um cliente
        return response()->json(['message' => 'Acesso negado'], 403);
    }
}
