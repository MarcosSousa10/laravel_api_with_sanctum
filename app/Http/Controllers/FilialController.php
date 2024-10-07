<?php

namespace App\Http\Controllers;

use App\Models\Filial; // Certifique-se de que o modelo Filial esteja criado
use Illuminate\Http\Request;
use App\Services\ApiResponse;

class FilialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todas as filiais
        $filiais = Filial::all();

        // Adiciona a URL da imagem para cada filial
        foreach ($filiais as $filial) {
            if ($filial->imagem) {
                $filial->imagem_url = asset('images/' . $filial->imagem);
            } else {
                $filial->imagem_url = null; // Se não houver imagem, define como null
            }
        }

        // Retorna todas as filiais com as URLs das imagens
        return ApiResponse::success($filiais);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ct' => 'required|string|max:20|unique:filiais',
            'endereco' => 'nullable|string|max:255',
            'nome' => 'required|string|max:100',
            'telefone' => 'required|string|max:20',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
        ]);

        // Tratando o upload da imagem
        if ($request->hasFile('imagem')) {
            $imageName = time() . '.' . $request->imagem->extension();
            $request->imagem->move(public_path('images'), $imageName);
        } else {
            $imageName = null; // Se não houver imagem, mantém como null
        }

        // Criando a filial com os dados validados e incluindo o nome da imagem
        $filial = Filial::create([
            'ct' => $request->input('ct'),
            'endereco' => $request->input('endereco'),
            'nome' => $request->input('nome'),
            'telefone' => $request->input('telefone'),
            'imagem' => $imageName, // Salvando o nome da imagem (ou null) no banco de dados
        ]);

        // Adiciona a URL completa da imagem na resposta
        if ($imageName) {
            $imageUrl = asset('images/' . $imageName); // Gera a URL pública da imagem
        } else {
            $imageUrl = null; // Se não houver imagem, mantém null
        }

        // Retorna a filial junto com a URL da imagem
        return ApiResponse::success([
            'filial' => $filial,
            'imagem_url' => $imageUrl
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Verifica se a filial existe
        $filial = Filial::find($id);

        if ($filial) {
            // Adiciona a URL da imagem à filial, se houver
            if ($filial->imagem) {
                $filial->imagem_url = asset('images/' . $filial->imagem);
            } else {
                $filial->imagem_url = null; // Se não houver imagem, define como null
            }

            // Retorna a filial com a URL da imagem
            return ApiResponse::success($filial);
        } else {
            return ApiResponse::error('Filial não encontrada', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ct' => 'required|string|max:20|unique:filiais,ct,' . $id,
            'endereco' => 'nullable|string|max:255',
            'nome' => 'required|string|max:100',
            'telefone' => 'required|string|max:20',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
        ]);

        $filial = Filial::find($id);
        if ($filial) {
            // Tratando o upload da imagem
            if ($request->hasFile('imagem')) {
                $imageName = time() . '.' . $request->imagem->extension();
                $request->imagem->move(public_path('images'), $imageName);
                $filial->imagem = $imageName; // Atualiza o nome da imagem
            }

            // Atualiza os outros campos
            $filial->update($request->only(['ct', 'endereco', 'nome', 'telefone']));
            return ApiResponse::success($filial);
        } else {
            return ApiResponse::error('Filial não encontrada', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filial = Filial::find($id);
        if ($filial) {
            $filial->delete();
            return ApiResponse::success('Filial deletada com sucesso');
        } else {
            return ApiResponse::error('Filial não encontrada', 404);
        }
    }
}
