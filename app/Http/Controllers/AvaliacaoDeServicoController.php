<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoDeServico;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class AvaliacaoDeServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traz as avaliações com os dados do cliente e agendamento (se necessário)
        $avaliacoes = AvaliacaoDeServico::with(['cliente', 'agendamento'])->get();
        
        return ApiResponse::success($avaliacoes);
    }
    
    public function verificarAvaliacao(Request $request, $agendamento_id)
    {
        $avaliado = AvaliacaoDeServico::where('agendamento_id', $agendamento_id)->exists();
        
        if ($avaliado) {
            return ApiResponse::success(['message' => 'Já foi avaliado.']);
        } else {
            return ApiResponse::success(['message' => 'Ainda não foi avaliado.']);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comentario' => 'nullable|string',
            'nota' => 'required|integer|min:1|max:5', 
            'agendamento_id' => 'required|exists:agendamentos,id',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $avaliacao = AvaliacaoDeServico::create($request->all());

        return ApiResponse::success($avaliacao);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $avaliacao = AvaliacaoDeServico::find($id);

        if ($avaliacao) {
            return ApiResponse::success($avaliacao);
        }

        return ApiResponse::error('Avaliação de Serviço not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'comentario' => 'nullable|string',
            'nota' => 'required|integer|min:1|max:5',
            'agendamento_id' => 'required|exists:agendamentos,id',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $avaliacao = AvaliacaoDeServico::find($id);

        if ($avaliacao) {
            $avaliacao->update($request->all());
            return ApiResponse::success($avaliacao);
        }

        return ApiResponse::error('Avaliação de Serviço not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $avaliacao = AvaliacaoDeServico::find($id);

        if ($avaliacao) {
            $avaliacao->delete();
            return ApiResponse::success('Avaliação de Serviço deleted successfully');
        }

        return ApiResponse::error('Avaliação de Serviço not found', 404);
    }
}
