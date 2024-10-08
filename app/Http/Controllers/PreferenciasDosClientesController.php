<?php

namespace App\Http\Controllers;

use App\Models\PreferenciasDosClientes;
use Illuminate\Http\Request;

class PreferenciasDosClientesController extends Controller
{
    /**
     * Exibe uma lista de preferências dos clientes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preferencias = PreferenciasDosClientes::all();
        return response()->json($preferencias);
    }

    /**
     * Armazena uma nova preferência de cliente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_preferencia' => 'required|string|max:100',
            'valor_preferencia' => 'nullable|string',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $preferencia = PreferenciasDosClientes::create($request->all());
        return response()->json($preferencia, 201);
    }

    /**
     * Exibe a preferência do cliente especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preferencia = PreferenciasDosClientes::findOrFail($id);
        return response()->json($preferencia);
    }

    /**
     * Atualiza a preferência do cliente especificado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_preferencia' => 'required|string|max:100',
            'valor_preferencia' => 'nullable|string',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $preferencia = PreferenciasDosClientes::findOrFail($id);
        $preferencia->update($request->all());
        return response()->json($preferencia);
    }

    /**
     * Remove a preferência do cliente especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preferencia = PreferenciasDosClientes::findOrFail($id);
        $preferencia->delete();
        return response()->json(null, 204);
    }
}
