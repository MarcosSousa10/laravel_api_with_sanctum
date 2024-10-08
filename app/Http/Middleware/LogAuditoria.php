<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LogDeAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAuditoria
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
        // Capturar a resposta da requisição
        $response = $next($request);

        // Capturar dados relevantes da requisição
        $usuario_id = Auth::check() ? Auth::user()->id : null; // ID do usuário autenticado, se existir
        $acao = $request->method() . ' ' . $request->path();   // Ação executada (Método + Caminho da API)
        $data_hora = now();                                    // Data e hora da requisição
        $detalhes = json_encode([
            'request' => $request->all(),                      // Detalhes da requisição
            'response_status' => $response->status()           // Status da resposta
        ]);
        $endereco_ip = $request->ip();                         // IP da requisição

        // Criar um registro de log no banco de dados
        LogDeAuditoria::create([
            'acao' => $acao,
            'data_hora' => $data_hora,
            'detalhes' => $detalhes,
            'endereco_ip' => $endereco_ip,
            'usuario_id' => $usuario_id,
        ]);

        return $response;
    }
}
