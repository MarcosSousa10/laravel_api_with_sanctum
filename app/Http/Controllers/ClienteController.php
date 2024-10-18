<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    // Método para listar todos os clientes
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }
   
    
    // Método para criar um novo cliente
    public function store(Request $request)
    {
        $request->validate([
            'data_nascimento' => 'required|date',
            'email' => 'required|email|unique:clientes,email',
            'endereco' => 'nullable|string|max:255',
            'nome' => 'required|string|unique:clientes,nome|max:100',
            'telefone' => 'required|string|max:20',
        ]);

        $cliente = Cliente::create($request->all());
        return response()->json($cliente, 201);
    }

    // Método para mostrar um cliente específico
    public function show($id)
    {
        $cliente = Cliente::find($id);
        return response()->json($cliente);
    }

    public function getByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $email = $request->query('email');
    
        Log::info("Email recebido: " . $email);
    
        $cliente = Cliente::where('email', $email)->first();
    
        Log::info("Cliente encontrado: " . json_encode($cliente));
    
        if ($cliente) {
            return response()->json($cliente);
        } else {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }
    }
    


    // Método para atualizar um cliente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $request->validate([
            'data_nascimento' => 'sometimes|date',
            'email' => 'sometimes|email|unique:clientes,email,' . $cliente->id,
            'endereco' => 'nullable|string|max:255',
            'nome' => 'sometimes|string|unique:clientes,nome,' . $cliente->id . '|max:100',
            'telefone' => 'sometimes|string|max:20',
        ]);

        $cliente->update($request->all());
        return response()->json($cliente);
    }

    // Método para deletar um cliente
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente deletado com sucesso']);
    }
}
