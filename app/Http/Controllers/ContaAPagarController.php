<?php

namespace App\Http\Controllers;

use App\Models\ContaAPagar;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class ContaAPagarController extends Controller
{
    /**
     * Exibe uma lista de contas a pagar.
     */
    public function index()
    {
        $contas = ContaAPagar::all();
        return ApiResponse::success($contas);
    }

    /**
     * Armazena uma nova conta a pagar.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data_pagamento' => 'nullable|date',
            'data_vencimento' => 'required|date',
            'descricao' => 'nullable|string',
            'nome_fornecedor' => 'required|string|max:100',
            'status' => 'required|string',
            'valor' => 'required|numeric',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $conta = ContaAPagar::create($request->all());

        return ApiResponse::success($conta);
    }

    /**
     * Exibe uma conta a pagar específica.
     */
    public function show($id)
    {
        $conta = ContaAPagar::find($id);

        if ($conta) {
            return ApiResponse::success($conta);
        }

        return ApiResponse::error('Conta a pagar não encontrada', 404);
    }

    /**
     * Atualiza uma conta a pagar.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'data_pagamento' => 'nullable|date',
            'data_vencimento' => 'required|date',
            'descricao' => 'nullable|string',
            'nome_fornecedor' => 'required|string|max:100',
            'status' => 'required|string',
            'valor' => 'required|numeric',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $conta = ContaAPagar::find($id);

        if ($conta) {
            $conta->update($request->all());
            return ApiResponse::success($conta);
        }

        return ApiResponse::error('Conta a pagar não encontrada', 404);
    }

    /**
     * Remove uma conta a pagar.
     */
    public function destroy($id)
    {
        $conta = ContaAPagar::find($id);

        if ($conta) {
            $conta->delete();
            return ApiResponse::success('Conta a pagar removida com sucesso');
        }

        return ApiResponse::error('Conta a pagar não encontrada', 404);
    }
}
