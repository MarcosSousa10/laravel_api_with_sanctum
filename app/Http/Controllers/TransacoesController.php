<?php

namespace App\Http\Controllers;

use App\Models\Transacoes;
use Illuminate\Http\Request;

class TransacoesController extends Controller
{
    public function index()
    {
        $transacoes = Transacoes::with(['agendamento', 'venda', 'filial'])->get(); // Carregar todos os relacionamentos
        return response()->json($transacoes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_transacao' => 'required|date',
            'metodo_pagamento' => 'required|string',
            'valor_pago' => 'required|numeric',
            'agendamento_id' => 'nullable|exists:agendamentos,id',
            'venda_id' => 'nullable|exists:vendas,id', // Validação para venda
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        // Verificar se pelo menos um dos dois (agendamento ou venda) foi fornecido
        if (!$request->agendamento_id && !$request->venda_id) {
            return response()->json(['error' => 'Você deve fornecer um agendamento ou uma venda.'], 422);
        }

        $transacao = Transacoes::create($request->all());
        return response()->json($transacao, 201);
    }

    public function show($id)
    {
        $transacao = Transacoes::with(['agendamento', 'venda', 'filial'])->findOrFail($id);
        return response()->json($transacao);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_transacao' => 'required|date',
            'metodo_pagamento' => 'required|string',
            'valor_pago' => 'required|numeric',
            'agendamento_id' => 'nullable|exists:agendamentos,id',
            'venda_id' => 'nullable|exists:vendas,id',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        if (!$request->agendamento_id && !$request->venda_id) {
            return response()->json(['error' => 'Você deve fornecer um agendamento ou uma venda.'], 422);
        }

        $transacao = Transacoes::findOrFail($id);
        $transacao->update($request->all());
        return response()->json($transacao);
    }

    public function destroy($id)
    {
        $transacao = Transacoes::findOrFail($id);
        $transacao->delete();
        return response()->json(null, 204);
    }
}
