<?php

namespace App\Http\Controllers;

use App\Models\PromocoesAtivas;
use Illuminate\Http\Request;

class PromocoesAtivasController extends Controller
{
    public function index()
    {
        $promocoes = PromocoesAtivas::all();
        return response()->json($promocoes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'desconto' => 'required|numeric',
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string|max:255',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $promocao = PromocoesAtivas::create($request->all());
        return response()->json($promocao, 201);
    }

    public function show($id)
    {
        $promocao = PromocoesAtivas::findOrFail($id);
        return response()->json($promocao);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'desconto' => 'required|numeric',
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string|max:255',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $promocao = PromocoesAtivas::findOrFail($id);
        $promocao->update($request->all());
        return response()->json($promocao);
    }

    public function destroy($id)
    {
        $promocao = PromocoesAtivas::findOrFail($id);
        $promocao->delete();
        return response()->json(null, 204);
    }
}
