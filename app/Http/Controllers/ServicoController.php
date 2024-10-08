<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicos = Servico::all();

        foreach ($servicos as $servico) {
            $servico->image_url = $servico->imagem ? asset('images/' . $servico->imagem) : null;
        }

        return ApiResponse::success($servicos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'descricao' => 'nullable',
            'duracao' => 'required|integer',
            'preco' => 'nullable|numeric',
            'filial_id' => 'required|exists:filiais,filial_id',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $imageName = time() . '.' . $request->imagem->extension();
            $request->imagem->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        $servico = Servico::create(array_merge($request->all(), ['imagem' => $imageName]));

        return ApiResponse::success([
            'servico' => $servico,
            'image_url' => $servico->imagem ? asset('images/' . $servico->imagem) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servico = Servico::find($id);

        if ($servico) {
            $servico->image_url = $servico->imagem ? asset('images/' . $servico->imagem) : null;
            return ApiResponse::success($servico);
        }

        return ApiResponse::error('Servico not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required',
            'descricao' => 'nullable',
            'duracao' => 'required|integer',
            'preco' => 'nullable|numeric',
            'filial_id' => 'required|exists:filiais,id',
        ]);

        $servico = Servico::find($id);

        if ($servico) {
            if ($request->hasFile('imagem')) {
                if ($servico->imagem) {
                    $oldImagePath = public_path('images/' . $servico->imagem);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $imageName = time() . '.' . $request->imagem->extension();
                $request->imagem->move(public_path('images'), $imageName);
                $servico->imagem = $imageName;
            }

            $servico->update($request->except('imagem'));

            return ApiResponse::success($servico);
        }

        return ApiResponse::error('Servico not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servico = Servico::find($id);

        if ($servico) {
            if ($servico->imagem) {
                $imagePath = public_path('images/' . $servico->imagem);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $servico->delete();
            return ApiResponse::success('Servico deleted successfully');
        }

        return ApiResponse::error('Servico not found', 404);
    }
}
