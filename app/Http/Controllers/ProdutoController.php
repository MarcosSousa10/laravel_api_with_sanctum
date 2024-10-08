<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'nullable|string|max:255',
            'estoquecd' => 'nullable|integer',
            'estoquedispothon' => 'nullable|integer',
            'estoqueothon' => 'nullable|integer',
            'giromes' => 'nullable|integer',
            'produtopai' => 'nullable|string|max:255',
            'qtachegar' => 'nullable|integer',
            'qtvendida3meses' => 'nullable|integer',
            'unidade' => 'nullable|string|max:255',
        ]);

        $produto = Produto::create($request->all());
        return response()->json($produto, 201);
    }

    public function show($codprod)
    {
        $produto = Produto::findOrFail($codprod);
        return response()->json($produto);
    }

    public function update(Request $request, $codprod)
    {
        $request->validate([
            'descricao' => 'nullable|string|max:255',
            'estoquecd' => 'nullable|integer',
            'estoquedispothon' => 'nullable|integer',
            'estoqueothon' => 'nullable|integer',
            'giromes' => 'nullable|integer',
            'produtopai' => 'nullable|string|max:255',
            'qtachegar' => 'nullable|integer',
            'qtvendida3meses' => 'nullable|integer',
            'unidade' => 'nullable|string|max:255',
        ]);

        $produto = Produto::findOrFail($codprod);
        $produto->update($request->all());
        return response()->json($produto);
    }

    public function destroy($codprod)
    {
        $produto = Produto::findOrFail($codprod);
        $produto->delete();
        return response()->json(null, 204);
    }
}
