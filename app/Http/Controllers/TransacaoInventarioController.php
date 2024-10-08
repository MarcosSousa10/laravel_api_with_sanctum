<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoInventarioController extends Controller
{
    public function index()
    {
        // Recupera todas as transações de inventário
        $transacaoInventario = DB::table('transacao_inventario')
            ->join('inventario', 'transacao_inventario.inventario_id', '=', 'inventario.id')
            ->join('transacoes', 'transacao_inventario.transacao_id', '=', 'transacoes.id')
            ->select('transacao_inventario.*', 'inventario.*', 'transacoes.*')
            ->get();

        return response()->json($transacaoInventario);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventario_id' => 'required|exists:inventario,id',
            'transacao_id' => 'required|exists:transacoes,id',
        ]);

        // Cria uma nova transação de inventário
        $transacaoInventario = DB::table('transacao_inventario')->insert([
            'inventario_id' => $request->inventario_id,
            'transacao_id' => $request->transacao_id,
        ]);

        return response()->json(['message' => 'Transação de inventário criada com sucesso'], 201);
    }

    public function show($inventario_id, $transacao_id)
    {
        // Recupera uma transação de inventário específica
        $transacaoInventario = DB::table('transacao_inventario')
            ->where('inventario_id', $inventario_id)
            ->where('transacao_id', $transacao_id)
            ->first();

        if (!$transacaoInventario) {
            return response()->json(['message' => 'Transação de inventário não encontrada'], 404);
        }

        return response()->json($transacaoInventario);
    }

    public function destroy($inventario_id, $transacao_id)
    {
        // Remove uma transação de inventário específica
        $deleted = DB::table('transacao_inventario')
            ->where('inventario_id', $inventario_id)
            ->where('transacao_id', $transacao_id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Transação de inventário excluída com sucesso'], 204);
        } else {
            return response()->json(['message' => 'Transação de inventário não encontrada'], 404);
        }
    }
}
