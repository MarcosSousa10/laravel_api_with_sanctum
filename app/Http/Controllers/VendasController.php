<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venda;
use App\Models\Inventario;
use App\Models\Transacoes;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class VendasController extends Controller
{
    /**
     * Registra uma nova venda no sistema.
     */
    public function store(Request $request)
    {
        // Valida os dados da requisição
        $request->validate([
            'cliente_id' => 'required|integer',
            'profissional_id' => 'required|integer',
            'inventarios' => 'required|array',
            'inventarios.*.inventario_id' => 'required|integer|exists:inventario,id',
            'inventarios.*.quantidade' => 'required|integer|min:1',
            'metodo_pagamento' => 'required|string',
        ]);

        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'profissional_id' => $request->profissional_id,
            'preco_total' => 0,
            'data_venda' => now(),
        ]);

        $precoTotal = 0;

        foreach ($request->inventarios as $produtoData) {
            $inventario = Inventario::find($produtoData['inventario_id']);

            if (!$inventario) {
                return response()->json(['error' => 'Inventário não encontrado'], 404);
            }

            if ($inventario->quantidade < $produtoData['quantidade']) {
                return response()->json(['error' => 'Quantidade solicitada não disponível'], 400);
            }

            $inventario->quantidade -= $produtoData['quantidade'];
            $inventario->save();

            $precoTotal += $inventario->preco * $produtoData['quantidade'];

            $venda->produtos()->attach($inventario->id, [
                'quantidade' => $produtoData['quantidade'],
                'preco_total' => $inventario->preco * $produtoData['quantidade'],
            ]);
        }

        // Atualiza o preço total da venda após adicionar todos os produtos
        $venda->preco_total = $precoTotal;
        $venda->save();

        // Criar automaticamente a transação após a venda
        $transacao = Transacoes::create([
            'data_transacao' => now(),
            'metodo_pagamento' => $request->metodo_pagamento, // Recebido do request
            'valor_pago' => $precoTotal,
            'venda_id' => $venda->id,
            'filial_id' => $request->filial_id,
        ]);

        $cliente = Cliente::find($request->cliente_id);
        $cliente->adicionarPontos($precoTotal);

        return response()->json([
            'venda' => $venda,
            'transacao' => $transacao,
        ], 201);
    }
    public function totalVendasDiaAtual()
{
    $total = Venda::whereDate('data_venda', now())->sum('preco_total');

    return response()->json([
        'total_vendas_dia_atual' => $total,
    ]);
}

    public function totalVendasMesAtual()
    {
        $total = Venda::whereYear('data_venda', now()->year)
                      ->whereMonth('data_venda', now()->month)
                      ->sum('preco_total');
    
        return response()->json([
            'total_vendas_mes_atual' => $total,
        ]);
    }
    
    public function totalVendasPorMes()
    {
        $vendasPorMes = Venda::selectRaw('SUM(preco_total) as total_vendas, MONTH(data_venda) as mes, YEAR(data_venda) as ano')
            ->groupBy('mes', 'ano')
            ->orderBy('ano', 'asc')
            ->orderBy('mes', 'asc')
            ->get();
    
        return response()->json($vendasPorMes);
    }
    public function store1(Request $request)
    {
        // Valida os dados da requisição
        $request->validate([
            'cliente_id' => 'required|integer',
            'profissional_id' => 'required|integer',
            'inventarios' => 'required|array',
            'inventarios.*.inventario_id' => 'required|integer|exists:inventario,id', // Verifica se o inventário existe
            'inventarios.*.quantidade' => 'required|integer|min:1',
        ]);

        // Cria uma nova venda
        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'profissional_id' => $request->profissional_id,
            'preco_total' => 0, // Inicialmente zero, será calculado mais tarde
            'data_venda' => now(),
        ]);

        $precoTotal = 0;

        // Adiciona produtos à venda e atualiza o inventário
        foreach ($request->inventarios as $produtoData) {
            // Busca o inventário pelo ID fornecido na requisição
            $inventario = Inventario::find($produtoData['inventario_id']);

            // Verifica se o inventário foi encontrado
            if (!$inventario) {
                return response()->json(['error' => 'Inventário não encontrado'], 404);
            }

            // Verifica se a quantidade desejada está disponível
            if ($inventario->quantidade < $produtoData['quantidade']) {
                return response()->json(['error' => 'Quantidade solicitada não disponível'], 400);
            }

            // Atualiza o estoque do inventário
            $inventario->quantidade -= $produtoData['quantidade'];
            $inventario->save();

            // Calcula o preço total
            $precoTotal += $inventario->preco * $produtoData['quantidade'];

            // Adiciona produtos à venda
            $venda->produtos()->attach($inventario->id, [
                'quantidade' => $produtoData['quantidade'],
                'preco_total' => $inventario->preco * $produtoData['quantidade'],
                // Você pode adicionar 'inventario_id' aqui se necessário
            ]);
        }

        // Atualiza o preço total da venda após adicionar todos os produtos
        $venda->preco_total = $precoTotal;
        $venda->save();

        // Retorna a venda após todos os produtos terem sido adicionados
        return response()->json($venda, 201);
    }



    private function calcularPrecoTotal($produtos)
    {
        $total = 0;

        foreach ($produtos as $produto) {
            $total += $produto->preco * $produto->pivot->quantidade; // Aqui assumindo que 'preco' é um atributo do modelo Produto
        }

        return $total;
    }

    /**
     * Exibe todas as vendas.
     */
    public function index()
    {
        $vendas = Venda::with(['inventario', 'cliente', 'profissional'])->get();
        return ApiResponse::success($vendas);
    }

    /**
     * Exibe uma venda específica.
     */
    public function show($id)
    {
        $venda = Venda::with(['inventario', 'cliente', 'profissional'])->find($id);

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
