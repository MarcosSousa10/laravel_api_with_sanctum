<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class InventarioController extends Controller
{
    /**
     * Exibe uma lista de produtos no inventário.
     */
    public function index()
    {
        $inventario = Inventario::with(['filial', 'fornecedor'])->get();
        return ApiResponse::success($inventario);
    }

    /**
     * Armazena um novo produto no inventário.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome_produto' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'preco' => 'required|decimal:0,2',
            'quantidade' => 'required|integer',
            'filial_id' => 'required|exists:filiais,filial_id',
            'fornecedor_id' => 'required|exists:fornecedores,id',
        ]);

        $inventario = Inventario::create($request->all());

        return ApiResponse::success($inventario);
    }

    /**
     * Exibe um produto específico do inventário.
     */
    public function show($id)
    {
        $inventario = Inventario::with(['filial', 'fornecedor'])->find($id);

        if ($inventario) {
            return ApiResponse::success($inventario);
        }

        return ApiResponse::error('Produto não encontrado', 404);
    }

    /**
     * Atualiza um produto no inventário.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_produto' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'preco' => 'required|decimal:0,2',
            'quantidade' => 'required|integer',
            'filial_id' => 'required|exists:filiais,filial_id',
            'fornecedor_id' => 'required|exists:fornecedores,id',
        ]);

        $inventario = Inventario::find($id);

        if ($inventario) {
            $inventario->update($request->all());
            return ApiResponse::success($inventario);
        }

        return ApiResponse::error('Produto não encontrado', 404);
    }

    /**
     * Remove um produto do inventário.
     */
    public function destroy($id)
    {
        $inventario = Inventario::find($id);

        if ($inventario) {
            $inventario->delete();
            return ApiResponse::success('Produto removido com sucesso');
        }

        return ApiResponse::error('Produto não encontrado', 404);
    }
}
