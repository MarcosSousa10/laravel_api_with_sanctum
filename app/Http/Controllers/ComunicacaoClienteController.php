<?php

namespace App\Http\Controllers;

use App\Models\ComunicacaoCliente;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ComunicacaoClienteController extends Controller
{
    /**
     * Exibe uma lista de comunicações de clientes.
     */
    public function index()
    {
        $comunicacoes = ComunicacaoCliente::with(['cliente', 'filial'])->get();
        return ApiResponse::success($comunicacoes);
    }

    /**
     * Armazena uma nova comunicação de cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assunto' => 'nullable|string|max:100',
            'data_contato' => 'required|date',
            'notas' => 'nullable|string',
            'tipo_contato' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $comunicacao = ComunicacaoCliente::create($request->all());

        return ApiResponse::success($comunicacao);
    }

    /**
     * Exibe uma comunicação de cliente específica.
     */
    public function show(string $id)
    {
        $comunicacao = ComunicacaoCliente::with(['cliente', 'filial'])->find($id);

        if ($comunicacao) {
            return ApiResponse::success($comunicacao);
        }

        return ApiResponse::error('Comunicação de cliente não encontrada', 404);
    }

    /**
     * Atualiza uma comunicação de cliente.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'assunto' => 'nullable|string|max:100',
            'data_contato' => 'required|date',
            'notas' => 'nullable|string',
            'tipo_contato' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $comunicacao = ComunicacaoCliente::find($id);

        if ($comunicacao) {
            $comunicacao->update($request->all());
            return ApiResponse::success($comunicacao);
        }

        return ApiResponse::error('Comunicação de cliente não encontrada', 404);
    }

    /**
     * Remove uma comunicação de cliente.
     */
    public function destroy(string $id)
    {
        $comunicacao = ComunicacaoCliente::find($id);

        if ($comunicacao) {
            $comunicacao->delete();
            return ApiResponse::success('Comunicação de cliente removida com sucesso');
        }

        return ApiResponse::error('Comunicação de cliente não encontrada', 404);
    }
}
