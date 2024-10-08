<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoDoSistema;
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class ConfiguracaoDoSistemaController extends Controller
{
    /**
     * Exibe uma lista de configurações do sistema.
     */
    public function index()
    {
        $configuracoes = ConfiguracaoDoSistema::all();
        return ApiResponse::success($configuracoes);
    }

    /**
     * Armazena uma nova configuração do sistema.
     */
    public function store(Request $request)
    {
        $request->validate([
            'chave_configuracao' => 'required|string|max:100|unique:configuracoes_do_sistema,chave_configuracao',
            'descricao' => 'nullable|string',
            'ultima_atualizacao' => 'required|date',
            'valor_configuracao' => 'required|string',
        ]);

        $configuracao = ConfiguracaoDoSistema::create($request->all());

        return ApiResponse::success($configuracao);
    }

    /**
     * Exibe uma configuração do sistema específica.
     */
    public function show($id)
    {
        $configuracao = ConfiguracaoDoSistema::find($id);

        if ($configuracao) {
            return ApiResponse::success($configuracao);
        }

        return ApiResponse::error('Configuração não encontrada', 404);
    }

    /**
     * Atualiza uma configuração do sistema.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'chave_configuracao' => 'required|string|max:100|unique:configuracoes_do_sistema,chave_configuracao,' . $id,
            'descricao' => 'nullable|string',
            'ultima_atualizacao' => 'required|date',
            'valor_configuracao' => 'required|string',
        ]);

        $configuracao = ConfiguracaoDoSistema::find($id);

        if ($configuracao) {
            $configuracao->update($request->all());
            return ApiResponse::success($configuracao);
        }

        return ApiResponse::error('Configuração não encontrada', 404);
    }

    /**
     * Remove uma configuração do sistema.
     */
    public function destroy($id)
    {
        $configuracao = ConfiguracaoDoSistema::find($id);

        if ($configuracao) {
            $configuracao->delete();
            return ApiResponse::success('Configuração removida com sucesso');
        }

        return ApiResponse::error('Configuração não encontrada', 404);
    }
}
