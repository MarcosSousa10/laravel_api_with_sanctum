<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentos = Agendamento::with(['cliente', 'filial', 'profissional', 'servico'])->get();
        return ApiResponse::success($agendamentos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data_hora_agendamento' => 'required|date',
            'notas' => 'nullable|string',
            'preco_total' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'required|exists:filiais,filial_id',
            'profissional_id' => 'required|exists:profissionais,id',
            'servico_id' => 'required|exists:servicos,id',
        ]);

        $agendamento = Agendamento::create($request->all());

        return ApiResponse::success($agendamento);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agendamento = Agendamento::with(['cliente', 'filial', 'profissional', 'servico'])->find($id);

        if ($agendamento) {
            return ApiResponse::success($agendamento);
        }

        return ApiResponse::error('Agendamento not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'data_hora_agendamento' => 'required|date',
            'notas' => 'nullable|string',
            'preco_total' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'required|exists:filiais,filial_id',
            'profissional_id' => 'required|exists:profissionais,id',
            'servico_id' => 'required|exists:servicos,id',
        ]);

        $agendamento = Agendamento::find($id);

        if ($agendamento) {
            $agendamento->update($request->all());
            return ApiResponse::success($agendamento);
        }

        return ApiResponse::error('Agendamento not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agendamento = Agendamento::find($id);

        if ($agendamento) {
            $agendamento->delete();
            return ApiResponse::success('Agendamento deleted successfully');
        }

        return ApiResponse::error('Agendamento not found', 404);
    }
    public function filtrarAgendados()
    {
        // Filtra os agendamentos com status 'AGENDADO'
        $agendamentos = Agendamento::with(['cliente', 'filial', 'profissional', 'servico'])
            ->where('status', 'AGENDADO')
            ->get();

        return ApiResponse::success($agendamentos);
    }

public function filtrarPorEmail(Request $request)
{
    // Valide o e-mail fornecido
    $request->validate([
        'email' => 'required|email',
    ]);

    $email = $request->input('email');

    // Inicie a consulta com os relacionamentos necessários
    $agendamentos = Agendamento::with(['cliente', 'filial', 'profissional', 'servico'])
        ->whereHas('cliente', function ($query) use ($email) {
            $query->where('email', $email);
        })
        ->get();

    return ApiResponse::success($agendamentos);
}

}
