<?php

namespace App\Http\Controllers;

use App\Models\CampanhaDeMarketing;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class CampanhaDeMarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campanhas = CampanhaDeMarketing::all();
        return ApiResponse::success($campanhas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'descricao' => 'nullable|string',
            'orçamento' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $campanha = CampanhaDeMarketing::create($request->all());

        return ApiResponse::success($campanha);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $campanha = CampanhaDeMarketing::find($id);

        if ($campanha) {
            return ApiResponse::success($campanha);
        }

        return ApiResponse::error('Campanha de Marketing not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'descricao' => 'nullable|string',
            'orçamento' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'filial_id' => 'required|exists:filiais,filial_id',
        ]);

        $campanha = CampanhaDeMarketing::find($id);

        if ($campanha) {
            $campanha->update($request->all());
            return ApiResponse::success($campanha);
        }

        return ApiResponse::error('Campanha de Marketing not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $campanha = CampanhaDeMarketing::find($id);

        if ($campanha) {
            $campanha->delete();
            return ApiResponse::success('Campanha de Marketing deleted successfully');
        }

        return ApiResponse::error('Campanha de Marketing not found', 404);
    }
}
