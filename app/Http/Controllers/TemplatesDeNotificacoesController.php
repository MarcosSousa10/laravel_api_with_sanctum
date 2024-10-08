<?php

namespace App\Http\Controllers;

use App\Models\TemplatesDeNotificacoes;
use Illuminate\Http\Request;

class TemplatesDeNotificacoesController extends Controller
{
    public function index()
    {
        $templates = TemplatesDeNotificacoes::all();
        return response()->json($templates);
    }

    public function store(Request $request)
    {
        $request->validate([
            'conteudo_template' => 'nullable|string',
            'nome_template' => 'required|string|max:100',
            'tipo_template' => 'required|string|max:255',
        ]);

        $template = TemplatesDeNotificacoes::create($request->all());
        return response()->json($template, 201);
    }

    public function show($id)
    {
        $template = TemplatesDeNotificacoes::findOrFail($id);
        return response()->json($template);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'conteudo_template' => 'nullable|string',
            'nome_template' => 'required|string|max:100',
            'tipo_template' => 'required|string|max:255',
        ]);

        $template = TemplatesDeNotificacoes::findOrFail($id);
        $template->update($request->all());
        return response()->json($template);
    }

    public function destroy($id)
    {
        $template = TemplatesDeNotificacoes::findOrFail($id);
        $template->delete();
        return response()->json(null, 204);
    }
}
