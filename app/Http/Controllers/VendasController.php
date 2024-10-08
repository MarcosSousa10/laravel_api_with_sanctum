<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendasController extends Controller
{
    public function index()
    {
        // Recupera todas as vendas
        $vendas = Venda::with(['cliente', 'filial', 'profissional'])->get();

        return response()->json($vendas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_venda' => 'required|date',
            'metodo_pagamento' => 'required|string|max:255',
            'valor_total' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'required|exists:filiais,filial_id',
            'profissional_id' => 'required|exists:profissionais,id',
        ]);

        // Cria uma nova venda
        $venda = Venda::create($request->all());

        return response()->json(['message' => 'Venda criada com sucesso', 'venda' => $venda], 201);
    }

    public function show($id)
    {
        // Recupera uma venda específica
        $venda = Venda::with(['cliente', 'filial', 'profissional'])->find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        return response()->json($venda);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_venda' => 'date',
            'metodo_pagamento' => 'string|max:255',
            'valor_total' => 'numeric',
            'cliente_id' => 'exists:clientes,id',
            'filial_id' => 'exists:filiais,filial_id',
            'profissional_id' => 'exists:profissionais,id',
        ]);

        // Atualiza a venda
        $venda = Venda::find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $venda->update($request->all());

        return response()->json(['message' => 'Venda atualizada com sucesso', 'venda' => $venda]);
    }

    public function destroy($id)
    {
        // Remove uma venda específica
        $venda = Venda::find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $venda->delete();

        return response()->json(['message' => 'Venda excluída com sucesso'], 204);
    }
}
