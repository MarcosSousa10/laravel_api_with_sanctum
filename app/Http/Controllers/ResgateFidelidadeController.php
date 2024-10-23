<?php

namespace App\Http\Controllers;

use App\Models\ResgateFidelidade;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ResgateFidelidadeController extends Controller
{
    public function resgatesPorEmail(Request $request)
    {
        $email = $request->input('email');

        $cliente = Cliente::where('email', $email)->first();
        
        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        $resgates = ResgateFidelidade::with('recompensa')
                    ->where('cliente_id', $cliente->id)
                    ->get();

        return response()->json($resgates);
    }

    public function resgatesPorClienteId($cliente_id)
    {
        $cliente = Cliente::findOrFail($cliente_id);

        $resgates = ResgateFidelidade::with('recompensa')
                    ->where('cliente_id', $cliente->id)
                    ->get();

        return response()->json($resgates);
    }

    public function todasRecompensasResgatadas()
    {
        $resgates = ResgateFidelidade::with(['cliente', 'recompensa'])->get();

        return response()->json($resgates);
    }
}
