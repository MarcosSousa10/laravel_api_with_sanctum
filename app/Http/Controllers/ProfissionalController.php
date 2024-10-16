<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profissionais = Profissional::all();
       // $host = request()->getHost(); // Obtém o host atual da requisição
      //  $host = '192.168.201.77:8000'; // Obtém o host atual da requisição
   //     $host = file_get_contents('https://ipinfo.io/ip');

        foreach ($profissionais as $profissional) {
            if ($profissional->imagem) {
            $profissional->image_url = asset('images/' . $profissional->imagem);
        } else {
            $filial->imagem_url = null; 
        }
    }
        return ApiResponse::success($profissionais);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:profissionais,nome',
            'email' => 'required|email|unique:profissionais,email',
            'telefone' => 'required',
            'especialidade' => 'required',
            'disponibilidade' => 'nullable',
            'taxa_comissao' => 'nullable|numeric',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('imagem')) {
            $imageName = time() . '.' . $request->imagem->extension();
            $request->imagem->move(public_path('images'), $imageName);
        }

        $profissional = Profissional::create(array_merge($request->all(), ['imagem' => $imageName]));

        return ApiResponse::success([
            'profissional' => $profissional,
            'image_url' => $profissional->imagem ? asset('images/' . $profissional->imagem) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profissional = Profissional::find($id);

        if ($profissional) {
            $profissional->image_url = $profissional->imagem ? asset('images/' . $profissional->imagem) : null;
            return ApiResponse::success($profissional);
        }

        return ApiResponse::error('Profissional not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return ApiResponse::error('Profissional not found', 404);
        }

        $request->validate([
            'nome' => 'required|unique:profissionais,nome,' . $profissional->id,
            'email' => 'required|email|unique:profissionais,email,' . $profissional->id,
            'telefone' => 'required',
            'especialidade' => 'required',
            'disponibilidade' => 'nullable',
            'taxa_comissao' => 'nullable|numeric',
        ]);

        if ($request->hasFile('imagem')) {
            // Delete old image if exists
            if ($profissional->imagem) {
                $oldImagePath = public_path('images/' . $profissional->imagem);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->imagem->extension();
            $request->imagem->move(public_path('images'), $imageName);
            $profissional->imagem = $imageName;
        }

        $profissional->update($request->except('imagem'));

        $profissional->image_url = $profissional->imagem ? asset('images/' . $profissional->imagem) : null;

        return ApiResponse::success($profissional);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return ApiResponse::error('Profissional not found', 404);
        }

        if ($profissional->imagem) {
            $imagePath = public_path('images/' . $profissional->imagem);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $profissional->delete();
        return ApiResponse::success('Profissional deleted successfully');
    }
}
