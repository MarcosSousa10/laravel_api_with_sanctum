<?php

namespace App\Http\Controllers;

use App\Models\Comissao;
use App\Models\Profissional;
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
    public function buscarComissoesPorEmail(Request $request)
    {
        // Verifica se o email foi passado na requisição
        $email = $request->query('email');
        
        if (!$email) {
            return ApiResponse::error('Email do profissional é necessário', 400);
        }
    
        // Busca o profissional pelo email
        $profissional = Profissional::where('email', $email)->first();
    
        // Verifica se o profissional foi encontrado
        if (!$profissional) {
            return ApiResponse::error('Profissional não encontrado', 404);
        }
    
        // Atribui a image_url, caso a imagem esteja disponível
        if ($profissional->imagem) {
            $profissional->image_url = asset('images/' . $profissional->imagem);
        } else {
            $profissional->image_url = null;
        }
    
        // Busca as comissões do profissional encontrado
        $comissoes = Comissao::where('profissional_id', $profissional->id)->get();
    
        // Verifica se foram encontradas comissões
        if ($comissoes->isEmpty()) {
            return ApiResponse::error('Nenhuma comissão encontrada para esse profissional', 404);
        }
    
        // Calcula o valor total das comissões
        $valorTotalComissoes = $comissoes->sum('valor_comissao');
    
        // Retorna a imagem e o valor total das comissões
        return ApiResponse::success([
            'image_url' => $profissional->image_url,
            'valor_total_comissoes' => $valorTotalComissoes
        ]);
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
