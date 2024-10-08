<?php

namespace App\Http\Controllers;

use App\Models\ProgramaFidelidade;
use Illuminate\Http\Request;

class ProgramaFidelidadeController extends Controller
{
    public function index()
    {
        $programas = ProgramaFidelidade::all();
        return response()->json($programas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'nullable|string',
            'disponibilidade_inicio' => 'required|date',
            'disponibilidade_fim' => 'required|date',
            'nome_recompensa' => 'required|string|max:100',
            'pontos_necessarios' => 'required|integer',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $programa = ProgramaFidelidade::create($request->all());
        return response()->json($programa, 201);
    }

    public function show($id)
    {
        $programa = ProgramaFidelidade::findOrFail($id);
        return response()->json($programa);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'nullable|string',
            'disponibilidade_inicio' => 'required|date',
            'disponibilidade_fim' => 'required|date',
            'nome_recompensa' => 'required|string|max:100',
            'pontos_necessarios' => 'required|integer',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $programa = ProgramaFidelidade::findOrFail($id);
        $programa->update($request->all());
        return response()->json($programa);
    }

    public function destroy($id)
    {
        $programa = ProgramaFidelidade::findOrFail($id);
        $programa->delete();
        return response()->json(null, 204);
    }
}
