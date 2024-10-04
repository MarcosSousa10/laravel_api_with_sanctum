<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Client::all(), 200);
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
        return response()->json(
            [
                'message' => ' Client created sucessfully',
                'data' => $cliente
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Client::find($id);
        if ($cliente) {
            return response()->json($cliente, 200);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
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
            return response()->json([
                'message' => 'Client update successfully',
                'data' => $client
            ], 200);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
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
            return response()->json([
                'message' => 'Client delete successfully'], 200);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }
}
