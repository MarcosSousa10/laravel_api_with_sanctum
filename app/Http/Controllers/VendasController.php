<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class VendasController extends Controller
{
    /**
     * Registra uma nova venda no sistema.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:inventario,id',
            'cliente_id' => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Inventario::find($request->produto_id);

        // Verifica se tem estoque suficiente
        if ($produto->quantidade < $request->quantidade) {
            return ApiResponse::error('Estoque insuficiente', 400);
        }

        // Atualiza o estoque do produto
        $produto->quantidade -= $request->quantidade;
        $produto->save();

        // Calcula o preço total
        $precoTotal = $produto->preco * $request->quantidade;

        // Cria a venda
        $venda = Venda::create([
            'produto_id' => $request->produto_id,
            'cliente_id' => $request->cliente_id,
            'profissional_id' => $request->profissional_id,
            'quantidade' => $request->quantidade,
            'preco_total' => $precoTotal,
            'data_venda' => now(),
        ]);

        return ApiResponse::success($venda);
    }

    /**
     * Exibe todas as vendas.
     */
    public function index()
    {
        $vendas = Venda::with(['produto', 'cliente', 'profissional'])->get();
        return ApiResponse::success($vendas);
    }

    /**
     * Exibe uma venda específica.
     */
    public function show($id)
    {
        $venda = Venda::with(['produto', 'cliente', 'profissional'])->find($id);

        if ($venda) {
            return ApiResponse::success($venda);
        }

        return ApiResponse::error('Venda não encontrada', 404);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $venda = Venda::find($id);

        if ($venda) {
            $venda->update($request->all());
            return ApiResponse::success($venda);
        }

        return ApiResponse::error('Venda não encontrada', 404);
    }
}
