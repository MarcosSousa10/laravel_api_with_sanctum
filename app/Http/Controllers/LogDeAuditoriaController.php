<?php

namespace App\Http\Controllers;

use App\Models\LogDeAuditoria;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class LogDeAuditoriaController extends Controller
{
    /**
     * Exibe uma lista de logs de auditoria.
     */
    public function index()
    {
        $logs = LogDeAuditoria::with('usuario')->get();
        return ApiResponse::success($logs);
    }

    /**
     * Armazena um novo log de auditoria.
     */
    public function store(Request $request)
    {
        $request->validate([
            'acao' => 'required|string|max:100',
            'data_hora' => 'required|date',
            'detalhes' => 'nullable|string',
            'endereco_ip' => 'nullable|string|max:45',
            'usuario_id' => 'nullable|exists:users,id',
        ]);

        $log = LogDeAuditoria::create($request->all());

        return ApiResponse::success($log);
    }

    /**
     * Exibe um log de auditoria específico.
     */
    public function show($id)
    {
        $log = LogDeAuditoria::with('usuario')->find($id);

        if ($log) {
            return ApiResponse::success($log);
        }

        return ApiResponse::error('Log não encontrado', 404);
    }

    /**
     * Atualiza um log de auditoria.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'acao' => 'required|string|max:100',
            'data_hora' => 'required|date',
            'detalhes' => 'nullable|string',
            'endereco_ip' => 'nullable|string|max:45',
            'usuario_id' => 'nullable|exists:users,id',
        ]);

        $log = LogDeAuditoria::find($id);

        if ($log) {
            $log->update($request->all());
            return ApiResponse::success($log);
        }

        return ApiResponse::error('Log não encontrado', 404);
    }

    /**
     * Remove um log de auditoria.
     */
    public function destroy($id)
    {
        $log = LogDeAuditoria::find($id);

        if ($log) {
            $log->delete();
            return ApiResponse::success('Log removido com sucesso');
        }

        return ApiResponse::error('Log não encontrado', 404);
    }
}
