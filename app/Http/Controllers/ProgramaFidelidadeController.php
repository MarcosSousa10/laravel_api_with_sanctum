<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ResgateFidelidade;
use App\Models\ProgramaFidelidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramaFidelidadeController extends Controller
{
    public function resgatarRecompensa(Request $request, $email, $recompensa_id)
{
    // Encontre o cliente pelo email
    $cliente = Cliente::where('email', $email)->firstOrFail();

    // Encontre a recompensa pelo ID e valide a disponibilidade
    $recompensa = ProgramaFidelidade::where('id', $recompensa_id)
        ->whereDate('disponibilidade_inicio', '<=', now())
        ->whereDate('disponibilidade_fim', '>=', now())
        ->firstOrFail();

    // Verifique se o cliente tem pontos suficientes
    if ($cliente->pontos < $recompensa->pontos_necessarios) {
        return response()->json([
            'message' => 'Pontos insuficientes para resgatar esta recompensa.'
        ], 400);
    }

    // Resgate a recompensa (debitando os pontos e salvando o resgate)
    DB::transaction(function () use ($cliente, $recompensa) {
        // Debita os pontos do cliente
        $cliente->pontos -= $recompensa->pontos_necessarios;
        $cliente->save();

        // Registra o resgate na tabela de resgates
        ResgateFidelidade::create([
            'cliente_id' => $cliente->id,
            'recompensa_id' => $recompensa->id,
            'pontos_utilizados' => $recompensa->pontos_necessarios,
        ]);
    });

    return response()->json([
        'message' => 'Recompensa resgatada com sucesso!',
        'recompensa' => $recompensa
    ], 200);
}

    public function resgatarRecompensa1(Request $request, $cliente_id, $recompensa_id)
{
    // Encontre o cliente pelo ID
    $cliente = Cliente::findOrFail($cliente_id);

    // Encontre a recompensa pelo ID e valide a disponibilidade
    $recompensa = ProgramaFidelidade::where('id', $recompensa_id)
        ->whereDate('disponibilidade_inicio', '<=', now())
        ->whereDate('disponibilidade_fim', '>=', now())
        ->firstOrFail();

    // Verifique se o cliente tem pontos suficientes
    if ($cliente->pontos < $recompensa->pontos_necessarios) {
        return response()->json([
            'message' => 'Pontos insuficientes para resgatar esta recompensa.'
        ], 400);
    }

    // Resgate a recompensa (debitando os pontos e salvando o resgate)
    DB::transaction(function () use ($cliente, $recompensa) {
        // Debita os pontos do cliente
        $cliente->pontos -= $recompensa->pontos_necessarios;
        $cliente->save();

        // Registra o resgate na tabela de resgates
        ResgateFidelidade::create([
            'cliente_id' => $cliente->id,
            'recompensa_id' => $recompensa->id,
            'pontos_utilizados' => $recompensa->pontos_necessarios,
        ]);
    });

    return response()->json([
        'message' => 'Recompensa resgatada com sucesso!',
        'recompensa' => $recompensa
    ], 200);
}
    public function resgatarRecompensa0(Request $request, $cliente_id, $recompensa_id)
    {
        // Encontre o cliente pelo ID
        $cliente = Cliente::findOrFail($cliente_id);

        // Encontre a recompensa pelo ID e valide a disponibilidade
        $recompensa = ProgramaFidelidade::where('id', $recompensa_id)
            ->whereDate('disponibilidade_inicio', '<=', now())
            ->whereDate('disponibilidade_fim', '>=', now())
            ->firstOrFail();

        // Verifique se o cliente tem pontos suficientes
        if ($cliente->pontos < $recompensa->pontos_necessarios) {
            return response()->json([
                'message' => 'Pontos insuficientes para resgatar esta recompensa.'
            ], 400);
        }

        // Resgate a recompensa (debitando os pontos)
        DB::transaction(function () use ($cliente, $recompensa) {
            $cliente->pontos -= $recompensa->pontos_necessarios;
            $cliente->save();


        });

        return response()->json([
            'message' => 'Recompensa resgatada com sucesso!',
            'recompensa' => $recompensa
        ], 200);
    }


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
