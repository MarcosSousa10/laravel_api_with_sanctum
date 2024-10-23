<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Profissional;
use App\Models\Comissao;
use App\Models\TransacaoInventario;
use App\Models\Transacoes;
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
    public function update(Request $request, string $id)
    {
        // Validação dos dados da requisição
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
    
        // Buscar o agendamento pelo ID
        $agendamento = Agendamento::find($id);
    
        if ($agendamento) {
            $agendamento->update($request->all());
    
            // Verifique se o status foi atualizado para "PAGO"
            if ($request->status === 'PAGO') {
                // Criar a transação automaticamente
                $transacao = Transacoes::create([
                    'agendamento_id' => $agendamento->id,
                    'data_transacao' => now(),
                    'metodo_pagamento' => $request->input('metodo_pagamento', 'indefinido'),
                    'valor_pago' => $agendamento->preco_total,
                    'filial_id' => $agendamento->filial_id,
                ]);
    
                // Buscar a taxa de comissão do profissional
                $profissional = Profissional::find($agendamento->profissional_id);
    
                if (!$profissional) {
                    return response()->json(['error' => 'Profissional não encontrado'], 404);
                }
    
                // Calcular o valor da comissão com base na taxa de comissão do profissional
                $valorComissao = ($profissional->taxa_comissao / 100) * $agendamento->preco_total;
    
                // Criar a comissão
                $comissao = Comissao::create([
                    'profissional_id' => $profissional->id,
                    'agendamento_id' => $agendamento->id,
                    'taxa_comissao' => $profissional->taxa_comissao,
                    'valor_comissao' => $valorComissao,
                    'data_comissao' => now(),
                ]);
    
                // Retornar o agendamento com a transação e comissão criada
                return ApiResponse::success([
                    'agendamento' => $agendamento,
                    'transacao' => $transacao,
                    'comissao' => $comissao,
                ]);
            }
    
            return ApiResponse::success($agendamento);
        }
    
        return ApiResponse::error('Agendamento não encontrado', 404);
    }
    
    
    /**
     * Update the specified resource in storage.
     */
    public function update0(Request $request, string $id)
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

            // Verifique se o status foi atualizado para "PAGO"
            if ($request->status === 'PAGO') {
                // Crie a transação automaticamente
                $transacao = Transacoes::create([
                    'agendamento_id' => $agendamento->id,
                    'data_transacao' => now(),
                    'metodo_pagamento' => $request->input('metodo_pagamento', 'indefinido'), // Exemplo: cartão, dinheiro, etc.
                    'valor_pago' => $agendamento->preco_total,
                    'filial_id' => $agendamento->filial_id,
                ]);

                // Retorna o agendamento com a transação criada
                return ApiResponse::success([
                    'agendamento' => $agendamento,
                    'transacao' => $transacao,
                ]);
            }

            return ApiResponse::success($agendamento);
        }

        return ApiResponse::error('Agendamento not found', 404);
    }

    public function update1(Request $request, string $id)
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
    public function filtrarPorEmailProfissional(Request $request)
{
    // Valide o e-mail fornecido
    $request->validate([
        'email' => 'required|email',
    ]);

    $email = $request->input('email');

    // Busque os agendamentos com status 'AGENDADO' e o e-mail do profissional
    $agendamentos = Agendamento::with(['cliente', 'filial', 'profissional', 'servico'])
        ->whereHas('profissional', function ($query) use ($email) {
            $query->where('email', $email);
        })
        ->where('status', 'AGENDADO')
        ->get();

    return ApiResponse::success($agendamentos);
}

}
