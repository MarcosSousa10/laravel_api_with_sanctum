<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class FornecedorController extends Controller
{
    /**
     * Exibe uma lista de fornecedores.
     */
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return ApiResponse::success($fornecedores);
    }

    /**
     * Armazena um novo fornecedor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome_fornecedor' => 'required|string|max:100',
            'email' => 'nullable|string|max:100',
            'contato' => 'nullable|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]); 

        $fornecedor = Fornecedor::create($request->all());

        return ApiResponse::success($fornecedor);
    }

    /**
     * Exibe um fornecedor específico.
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::find($id);

        if ($fornecedor) {
            return ApiResponse::success($fornecedor);
        }

        return ApiResponse::error('Fornecedor não encontrado', 404);
    }

    /**
     * Atualiza um fornecedor.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_fornecedor' => 'required|string|max:100',
            'email' => 'nullable|string|max:100',
            'contato' => 'nullable|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $fornecedor = Fornecedor::find($id);

        if ($fornecedor) {
            $fornecedor->update($request->all());
            return ApiResponse::success($fornecedor);
        }

        return ApiResponse::error('Fornecedor não encontrado', 404);
    }

    /**
     * Remove um fornecedor.
     */
    public function destroy($id)
    {
        $fornecedor = Fornecedor::find($id);

        if ($fornecedor) {
            $fornecedor->delete();
            return ApiResponse::success('Fornecedor removido com sucesso');
        }

        return ApiResponse::error('Fornecedor não encontrado', 404);
    }
}
