<?php

namespace App\Http\Controllers;

use App\Models\Comissao;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ComissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comissoes = Comissao::with(['agendamento', 'profissional'])->get();
        return ApiResponse::success($comissoes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'taxa_comissao' => 'required|numeric|min:0|max:100',
            'valor_comissao' => 'required|numeric|min:0',
        ]);

        $comissao = Comissao::create($request->all());

        return ApiResponse::success($comissao);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comissao = Comissao::with(['agendamento', 'profissional'])->find($id);

        if ($comissao) {
            return ApiResponse::success($comissao);
        }

        return ApiResponse::error('Comissão not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'taxa_comissao' => 'required|numeric|min:0|max:100',
            'valor_comissao' => 'required|numeric|min:0',
        ]);

        $comissao = Comissao::find($id);

        if ($comissao) {
            $comissao->update($request->all());
            return ApiResponse::success($comissao);
        }

        return ApiResponse::error('Comissão not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comissao = Comissao::find($id);

        if ($comissao) {
            $comissao->delete();
            return ApiResponse::success('Comissão deleted successfully');
        }

        return ApiResponse::error('Comissão not found', 404);
    }
}
