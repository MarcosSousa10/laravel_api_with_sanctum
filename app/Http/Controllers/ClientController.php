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
        if (!auth()->user()->tokenCan('clients:list')) {
            return ApiResponse::error('Access danied', 401);
        }


        // return response()->json(Client::all(), 200);

        return ApiResponse::success(Client::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:clients",
            "phone" => "required"
        ]);
        $cliente = Client::create($request->all());
        return ApiResponse::success($cliente);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('clients:detail')) {
            return ApiResponse::error('Access danied', 401);
        }

        $cliente = Client::find($id);
        if ($cliente) {
            return ApiResponse::success($cliente);
        } else {
            return ApiResponse::error('Client not found');
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
