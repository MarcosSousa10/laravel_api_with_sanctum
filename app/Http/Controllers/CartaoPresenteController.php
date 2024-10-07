<?php

namespace App\Http\Controllers;

use App\Models\CartaoPresente;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class CartaoPresenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartoes = CartaoPresente::all();
        return ApiResponse::success($cartoes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:100|unique:cartoes_presente,codigo',
            'data_emissao' => 'required|date',
            'data_expiracao' => 'required|date|after:data_emissao',
            'data_resgate' => 'nullable|date|after:data_emissao',
            'status' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'emitido_para_cliente_id' => 'nullable|exists:clientes,id',
            'resgatado_por_cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $cartao = CartaoPresente::create($request->all());

        return ApiResponse::success($cartao);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cartao = CartaoPresente::find($id);

        if ($cartao) {
            return ApiResponse::success($cartao);
        }

        return ApiResponse::error('Cartão Presente not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'codigo' => 'required|string|max:100|unique:cartoes_presente,codigo,'.$id,
            'data_emissao' => 'required|date',
            'data_expiracao' => 'required|date|after:data_emissao',
            'data_resgate' => 'nullable|date|after:data_emissao',
            'status' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'emitido_para_cliente_id' => 'nullable|exists:clientes,id',
            'resgatado_por_cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $cartao = CartaoPresente::find($id);

        if ($cartao) {
            $cartao->update($request->all());
            return ApiResponse::success($cartao);
        }

        return ApiResponse::error('Cartão Presente not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartao = CartaoPresente::find($id);

        if ($cartao) {
            $cartao->delete();
            return ApiResponse::success('Cartão Presente deleted successfully');
        }

        return ApiResponse::error('Cartão Presente not found', 404);
    }
}
