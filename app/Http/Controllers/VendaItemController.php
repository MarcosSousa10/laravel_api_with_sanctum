<?php

namespace App\Http\Controllers;

use App\Models\VendaItem;
use Illuminate\Http\Request;

class VendaItemController extends Controller
{
    // Listar todos os itens de venda
    public function index()
    {
        $itens = VendaItem::all();
        return response()->json($itens);
    }

    // Criar um novo item de venda
    public function store(Request $request)
    {
        $request->validate([
            'quantidade' => 'required|integer',
            'inventario_id' => 'required|exists:inventario,id',
            'venda_id' => 'nullable|exists:vendas,id',
        ]);

        $item = VendaItem::create($request->all());
        return response()->json($item, 201); // Retorna o item criado com status 201
    }

    // Exibir um item de venda específico
    public function show($id)
    {
        $item = VendaItem::findOrFail($id);
        return response()->json($item);
    }

    // Atualizar um item de venda
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer',
            'inventario_id' => 'required|exists:inventario,id',
            'venda_id' => 'nullable|exists:vendas,id',
        ]);

        $item = VendaItem::findOrFail($id);
        $item->update($request->all());
        return response()->json($item);
    }

    // Excluir um item de venda
    public function destroy($id)
    {
        $item = VendaItem::findOrFail($id);
        $item->delete();
        return response()->json(null, 204); // Retorna resposta 204 sem conteúdo
    }
}
