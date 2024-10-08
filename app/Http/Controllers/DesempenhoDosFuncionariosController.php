<?php

namespace App\Http\Controllers;

use App\Models\DesempenhoDosFuncionarios;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class DesempenhoDosFuncionariosController extends Controller
{
    /**
     * Exibe uma lista de desempenho dos funcionários.
     */
    public function index()
    {
        $desempenhos = DesempenhoDosFuncionarios::all();
        return ApiResponse::success($desempenhos);
    }

    /**
     * Armazena um novo registro de desempenho.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data_registro' => 'required|date',
            'tipo_metrica' => 'required|string|max:100',
            'valor_metrica' => 'required|numeric',
            'profissional_id' => 'required|exists:profissionais,id',
        ]);

        $desempenho = DesempenhoDosFuncionarios::create($request->all());

        return ApiResponse::success($desempenho);
    }

    /**
     * Exibe um registro específico de desempenho.
     */
    public function show($id)
    {
        $desempenho = DesempenhoDosFuncionarios::find($id);

        if ($desempenho) {
            return ApiResponse::success($desempenho);
        }

        return ApiResponse::error('Desempenho não encontrado', 404);
    }

    /**
     * Atualiza um registro de desempenho.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'data_registro' => 'required|date',
            'tipo_metrica' => 'required|string|max:100',
            'valor_metrica' => 'required|numeric',
            'profissional_id' => 'required|exists:profissionais,id',
        ]);

        $desempenho = DesempenhoDosFuncionarios::find($id);

        if ($desempenho) {
            $desempenho->update($request->all());
            return ApiResponse::success($desempenho);
        }

        return ApiResponse::error('Desempenho não encontrado', 404);
    }

    /**
     * Remove um registro de desempenho.
     */
    public function destroy($id)
    {
        $desempenho = DesempenhoDosFuncionarios::find($id);

        if ($desempenho) {
            $desempenho->delete();
            return ApiResponse::success('Registro de desempenho removido com sucesso');
        }

        return ApiResponse::error('Desempenho não encontrado', 404);
    }
}
