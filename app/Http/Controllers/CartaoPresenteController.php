<?php

namespace App\Http\Controllers;

use App\Models\CartaoPresente;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'status' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'emitido_para_cliente_id' => 'nullable|exists:clientes,id',
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

        return ApiResponse::error('Cartão Presente não encontrado', 404);
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
            'status' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'emitido_para_cliente_id' => 'nullable|exists:clientes,id',
        ]);

        $cartao = CartaoPresente::find($id);

        if ($cartao) {
            $cartao->update($request->all());
            return ApiResponse::success($cartao);
        }

        return ApiResponse::error('Cartão Presente não encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartao = CartaoPresente::find($id);

        if ($cartao) {
            $cartao->delete();
            return ApiResponse::success('Cartão Presente deletado com sucesso');
        }

        return ApiResponse::error('Cartão Presente não encontrado', 404);
    }

    /**
     * Resgatar um cartão presente.
     */
    public function resgatar(Request $request, string $id)
    {
        $request->validate([
            'resgatado_por_cliente_id' => 'required|exists:clientes,id',
        ]);

        $cartao = CartaoPresente::find($id);

        if ($cartao && $cartao->status !== 'resgatado') {
            $cartao->status = 'resgatado';
            $cartao->data_resgate = Carbon::now();
            $cartao->resgatado_por_cliente_id = $request->resgatado_por_cliente_id;
            $cartao->save();

            return ApiResponse::success('Cartão Presente resgatado com sucesso');
        }

        return ApiResponse::error('Cartão Presente já foi resgatado ou não encontrado', 404);
    }

    /**
     * Verificar o saldo do cartão presente.
     */
    public function verificarSaldo(string $codigo)
    {
        $cartao = CartaoPresente::where('codigo', $codigo)->first();

        if ($cartao) {
            return ApiResponse::success([
                'codigo' => $cartao->codigo,
                'valor' => $cartao->valor,
                'status' => $cartao->status
            ]);
        }

        return ApiResponse::error('Cartão Presente não encontrado', 404);
    }
}
