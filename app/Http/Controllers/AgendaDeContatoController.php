<?php

namespace App\Http\Controllers;

use App\Models\AgendaDeContato;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class AgendaDeContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendas = AgendaDeContato::all();
        return ApiResponse::success($agendas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'criterios' => 'nullable|string',
            'descricao' => 'nullable|string',
        ]);

        $agenda = AgendaDeContato::create($request->all());

        return ApiResponse::success($agenda);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agenda = AgendaDeContato::find($id);

        if ($agenda) {
            return ApiResponse::success($agenda);
        }

        return ApiResponse::error('Agenda de Contato not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'criterios' => 'nullable|string',
            'descricao' => 'nullable|string',
        ]);

        $agenda = AgendaDeContato::find($id);

        if ($agenda) {
            $agenda->update($request->all());
            return ApiResponse::success($agenda);
        }

        return ApiResponse::error('Agenda de Contato not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agenda = AgendaDeContato::find($id);

        if ($agenda) {
            $agenda->delete();
            return ApiResponse::success('Agenda de Contato deleted successfully');
        }

        return ApiResponse::error('Agenda de Contato not found', 404);
    }
}
