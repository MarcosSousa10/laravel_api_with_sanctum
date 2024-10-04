<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ApiResponse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Bloqueio na Classe Não precisa colocar na rota, só se quiser
        // if (!auth()->user()->tokenCan('clients:list')) {
        //     return ApiResponse::error('Access denied', 401);
        // }

        // Busca todos os clientes
        $clientes = Client::all();

        // Adiciona a URL da imagem para cada cliente
        foreach ($clientes as $cliente) {
            if ($cliente->image) {
                $cliente->image_url = asset('images/' . $cliente->image);
            } else {
                $cliente->image_url = null; // Se não houver imagem, define como null
            }
        }

        // Retorna todos os clientes com as URLs das imagens
        return ApiResponse::success($clientes);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
        ]);

        // Tratando o upload da imagem
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = null; // Se não houver imagem, mantém como null
        }

        // Criando o cliente com os dados validados e incluindo o nome da imagem
        $cliente = Client::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'image' => $imageName, // Salvando o nome da imagem (ou null) no banco de dados
        ]);

        // Adiciona a URL completa da imagem na resposta
        if ($imageName) {
            $imageUrl = asset('images/' . $imageName); // Gera a URL pública da imagem
        } else {
            $imageUrl = null; // Se não houver imagem, mantém null
        }

        // Retorna o cliente junto com a URL da imagem
        return ApiResponse::success([
            'client' => $cliente,
            'image_url' => $imageUrl
        ]);
    }



    public function show1(string $id)
    {
        // Verifica se o token tem permissão para visualizar os detalhes dos clientes
        //  if (!auth()->user()->tokenCan('clients:detail')) {
        //      return ApiResponse::error('Access denied', 401);
        //  }

        // Busca o cliente pelo ID
        $cliente = Client::find($id);

        // Verifica se o cliente existe
        if ($cliente) {
            // Checa se há uma imagem associada
            if ($cliente->image) {
                $imagePath = public_path('images/' . $cliente->image);

                // Verifica se a imagem existe no servidor
                if (file_exists($imagePath)) {
                    // Retorna a imagem como resposta
                    return response()->file($imagePath);
                } else {
                    return ApiResponse::error('Image not found', 404);
                }
            } else {
                return ApiResponse::error('Client has no image', 404);
            }
        } else {
            return ApiResponse::error('Client not found', 404);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //   if (!auth()->user()->tokenCan('clients:detail')) {
        //      return ApiResponse::error('Access danied', 401);
        //   }
        // Verifica se o cliente existe
        $cliente = Client::find($id);

        if ($cliente) {
            // Adiciona a URL da imagem ao cliente, se houver
            if ($cliente->image) {
                $cliente->image_url = asset('images/' . $cliente->image);
            } else {
                $cliente->image_url = null; // Se não houver imagem, define como null
            }

            // Retorna o cliente com a URL da imagem
            return ApiResponse::success($cliente);
        } else {
            return ApiResponse::error('Client not found', 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:clients,email," . $id,
            "phone" => "required"
        ]);
        $client = Client::find($id);
        if ($client) {
            $client->update($request->all());
            return ApiResponse::success($client);
        } else {
            return ApiResponse::error('Client not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            return ApiResponse::success('Client delete successfully');
        } else {
            return ApiResponse::error('Client not found');
        }
    }
}
